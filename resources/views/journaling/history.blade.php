<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emolog - History</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Header -->
    <header class="navbar">
        <div class="logo">
            <a href="../home">
                <img src="{{ asset('images/emolog512fix.png') }}" alt="Logo" />
            </a>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="{{ route('journaling') }}">Diary</a></li>
                <li><a href="{{ route('history') }}" class="active">History</a></li>
                <li><a href="{{ route('setting') }}">Setting</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content-history">
        <!-- Mode Toggle -->
        <div class="toggle-mode">
            <button id="dayBtn" class="toggle-btn active">Day</button>
            <button id="weekBtn" class="toggle-btn">Week</button>
        </div>

        <!-- Calendar Section -->
        <div class="calendar-section">
            <!-- Day View -->
            <div id="dayView">
                <div class="calendar-header">
                    <button class="nav-btn" id="prevMonth">&lt;</button>
                    <h2 class="calendar-title" id="dayMonthTitle"></h2>
                    <button class="nav-btn" id="nextMonth">&gt;</button>
                </div>
                <div class="calendar-grid" id="calendarDays"></div>
            </div>

            <!-- Week View -->
            <div id="weekView" style="display: none">
                <div class="calendar-header">
                    <button class="nav-btn" id="prevWeek">&lt;</button>
                    <h2 class="calendar-title" id="weekRangeTitle"></h2>
                    <button class="nav-btn" id="nextWeek">&gt;</button>
                </div>
            </div>
        </div>

        <!-- Diary List -->
        <div id="diaryList"></div>

        <!-- Floating Button -->
        <form method="GET" id="createForm" action="{{ route('journaling') }}">
            <input type="hidden" name="date" id="selectedDateInput" value="{{ now()->toDateString() }}">
            <button type="submit" class="floating-btn">+</button>
        </form>
    </main>

    <!-- Scripts -->
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const selectedDateInput = document.getElementById('selectedDateInput');
        const dayView = document.getElementById('dayView');
        const weekView = document.getElementById('weekView');
        const calendarDays = document.getElementById('calendarDays');
        const dayBtn = document.getElementById('dayBtn');
        const weekBtn = document.getElementById('weekBtn');

        let currentDate = new Date();

        function generateDiaryCard(entry) {
            return `
                <div class="card journal-card">
                    <div class="journal-entry">
                        <h5 class="entry-title">${entry.title}</h5>
                        <p class="entry-text">${entry.content}</p>
                        <div class="mt-2">
                            <a href="/diaries/${entry.id}/edit" class="btn btn-outline-primary">Edit</a>
                            <form method="POST" action="/diaries/${entry.id}" class="delete-form" data-id="${entry.id}">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>`;
        }

        function loadDayDiary(date) {
            fetch(`/diaries/day?date=${date}`, { headers: { 'Accept': 'application/json' } })
                .then(res => res.json())
                .then(data => {
                    const diaryList = document.getElementById('diaryList');
                    diaryList.innerHTML = data.diaries?.length
                        ? data.diaries.map(entry => generateDiaryCard(entry)).join('')
                        : '<p class="text-muted">Tidak ada entri diary hari ini.</p>';
                });
        }

        function loadWeekDiary(start, end) {
            fetch(`/diaries/week?start_date=${start}&end_date=${end}`, { headers: { 'Accept': 'application/json' } })
                .then(res => res.json())
                .then(data => {
                    const diaryList = document.getElementById('diaryList');
                    diaryList.innerHTML = data.length
                        ? data.map(entry => generateDiaryCard(entry)).join('')
                        : '<p class="text-muted">Tidak ada entri minggu ini.</p>';
                });
        }

        function renderCalendar(date) {
            const monthTitle = document.getElementById('dayMonthTitle');
            const year = date.getFullYear();
            const month = date.getMonth();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const startDay = new Date(year, month, 1).getDay();

            monthTitle.textContent = date.toLocaleString('default', { month: 'long', year: 'numeric' });
            calendarDays.innerHTML = '<div class="day-header">M</div><div class="day-header">T</div><div class="day-header">W</div><div class="day-header">T</div><div class="day-header">F</div><div class="day-header">S</div><div class="day-header">S</div>';

            for (let i = 0; i < (startDay + 6) % 7; i++) {
                calendarDays.innerHTML += '<div class="calendar-day empty"></div>';
            }

            for (let d = 1; d <= daysInMonth; d++) {
                const thisDate = new Date(year, month, d);
                const isoDate = thisDate.toISOString().split('T')[0];
                calendarDays.innerHTML += `<button class="calendar-day" data-date="${isoDate}">${d}</button>`;
            }

            document.querySelectorAll('.calendar-day[data-date]').forEach(btn => {
                btn.addEventListener('click', e => {
                    document.querySelectorAll('.calendar-day').forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                    selectedDateInput.value = btn.dataset.date;
                    loadDayDiary(btn.dataset.date);
                });
            });
        }

        function getWeekRange(date) {
            const day = date.getDay();
            const diffToMonday = (day + 6) % 7;
            const monday = new Date(date);
            monday.setDate(date.getDate() - diffToMonday);
            const sunday = new Date(monday);
            sunday.setDate(monday.getDate() + 6);
            return [monday, sunday];
        }

        function updateWeekView(date) {
            const [start, end] = getWeekRange(date);
            const weekRangeTitle = document.getElementById('weekRangeTitle');
            weekRangeTitle.textContent = `${start.toDateString().slice(4, 10)} - ${end.toDateString().slice(4, 10)}`;
            loadWeekDiary(start.toISOString().split('T')[0], end.toISOString().split('T')[0]);
        }

        document.getElementById('prevMonth').onclick = () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate);
        };

        document.getElementById('nextMonth').onclick = () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate);
        };

        document.getElementById('prevWeek').onclick = () => {
            currentDate.setDate(currentDate.getDate() - 7);
            updateWeekView(currentDate);
        };

        document.getElementById('nextWeek').onclick = () => {
            currentDate.setDate(currentDate.getDate() + 7);
            updateWeekView(currentDate);
        };

        dayBtn.onclick = () => {
            dayBtn.classList.add('active');
            weekBtn.classList.remove('active');
            dayView.style.display = '';
            weekView.style.display = 'none';
            renderCalendar(currentDate);
        };

        weekBtn.onclick = () => {
            weekBtn.classList.add('active');
            dayBtn.classList.remove('active');
            dayView.style.display = 'none';
            weekView.style.display = '';
            updateWeekView(currentDate);
        };

        document.addEventListener('DOMContentLoaded', () => {
            renderCalendar(currentDate);
            const today = new Date().toISOString().split('T')[0];
            selectedDateInput.value = today;
            loadDayDiary(today);

            document.body.addEventListener('submit', function (e) {
                if (e.target.classList.contains('delete-form')) {
                    e.preventDefault();
                    if (confirm('Yakin ingin menghapus diary ini?')) {
                        const form = e.target;
                        const id = form.dataset.id;
                        fetch(`/diaries/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ _method: 'DELETE' })
                        })
                        .then(() => {
                            form.closest('.journal-card').remove();
                        })
                        .catch(err => alert('Gagal menghapus diary.'));
                    }
                }
            });
        });
    </script>
</body>
</html>
