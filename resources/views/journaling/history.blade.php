<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emolog - History</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body>
    <!-- Header -->
    <header class="navbar">
        <div class="logo">
         <a href="../home">
           <img src="{{asset('images/emolog512fix.png')}}" alt="Logo" />
          </a>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="{{route('journaling')}}">Diary</a></li>
                <li><a href="{{route('history')}}" class="active">History</a></li>
                <li><a href="{{route('setting')}}">Setting</a></li>
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
                    <button class="nav-btn"><</button>
                    <h2 class="calendar-title">June, 2025</h2>
                    <button class="nav-btn">></button>
                </div>
                <div class="calendar-grid">
                    <div class="day-header">M</div>
                    <div class="day-header">T</div>
                    <div class="day-header">W</div>
                    <div class="day-header">T</div>
                    <div class="day-header">F</div>
                    <div class="day-header">S</div>
                    <div class="day-header">S</div>
                    <button class="calendar-day selected">2</button>
                    <button class="calendar-day">3</button>
                    <button class="calendar-day">4</button>
                    <button class="calendar-day">5</button>
                    <button class="calendar-day">6</button>
                    <button class="calendar-day">7</button>
                    <button class="calendar-day">8</button>
                </div>
            </div>

            <!-- Week View -->
            <div id="weekView" style="display: none">
            <div class="calendar-header">
                    <button class="nav-btn"><</button>
                    <h2 class="calendar-title">Jun 02 - Jun 08</h2>
                    <button class="nav-btn">></button>
                </div>
            </div>
        </div>

        <!-- Diary List -->
        <div class="card journal-card">
            <div class="journal-entry">
                <h5 class="entry-title">Bahagia</h5>
                <p class="entry-text">Hari ini sangat bahagia sekali.</p>
            </div>
        </div>

        <!-- Floating Button -->
        <button class="floating-btn">+</button>
    </main>

    <!-- Script to handle view toggle -->
    <script>
        document.getElementById('dayBtn').addEventListener('click',function(){
            document.getElementById('dayView').style.display = '';
            document.getElementById('weekView').style.display = 'none';
            this.classList.add('active');
            document.getElementById('weekBtn').classList.remove('active'); 
        });

        document.getElementById('weekBtn').addEventListener('click',function(){
            document.getElementById('dayView').style.display = 'none';
            document.getElementById('weekView').style.display = '';
            this.classList.add('active'); 
            document.getElementById('dayBtn').classList.remove('active'); 
        });
    </script>

</body>
</html>