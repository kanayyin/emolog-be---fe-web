<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emolog Homepage</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    
</head>
<body>
    @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    <!-- Navbar -->
    <header class="navbar">
        <div class="logo">
            <a href="{{ route('home') }}">
             <img src="{{ asset('images/emolog512fix.png') }}" alt="Logo">
            </a>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="{{route('journaling')}}">Diary</a></li>
                <li><a href="{{route('history')}}" >History</a></li>
                <li><a href="{{route('setting')}}">Setting</a></li>
            </ul>
        </nav>
    </header>

    


    <!-- Main Content will be added later -->
    <main class="main-content-home">

        

        <!-- Greeting Section -->
        <section class="greeting">
            <div class="greeting-content">
                <div class="greeting-text">
                    <h1>Hello, {{ Auth::user()->username }}!</h1>
                    <h3>Nice to meet you here!</h3>
                    <p></p>
                    <p>Don’t worry about making it perfect—just be honest. One day, when you need a little motivation or want to see how far you’ve come, you can revisit this first entry. Your emotions matter, and Emolog is here to be your safe space to express them.</p>
                    <a href="{{ route('journaling') }}" class="start-journaling-btn">Start Journaling</a>

                </div>

                <!-- Placeholder in the same box -->
                <div class="placeholder">
                    <p>Quotes disini</p>
                </div>
            </div>
        </section>

        <!-- Recap A Week Section -->
         @php
            use Carbon\Carbon;

            $prevWeek = Carbon::parse($start)->subWeek();
            $nextWeek = Carbon::parse($start)->addWeek();
        @endphp
<section class="recap-week-section">
    <h2 class="recap-week-header">Recap a week</h2>

    <div class="week-nav">
        <a href="{{ route('home', ['start_date' => $prevWeek->format('Y-m-d')]) }}" class="nav-arrow">&lt;</a>

        <span class="nav-date">
            {{ Carbon::parse($start)->translatedFormat('j M') }} - {{ Carbon::parse($end)->translatedFormat('j M') }}
        </span>

        <a href="{{ route('home', ['start_date' => $nextWeek->format('Y-m-d')]) }}" class="nav-arrow">&gt;</a>
    </div>


    <div class="week-container">
        @foreach ($dateRange as $date)
            @php
                $carbonDate = \Carbon\Carbon::parse($date);
                $dayName = $carbonDate->translatedFormat('l');
                $dayFormatted = $carbonDate->format('d M');
                $dayMood = $moodByDay[$date] ?? ['happy' => 0, 'neutral' => 0, 'sad' => 0];
                $maxMood = array_keys($dayMood, max($dayMood));
            @endphp


            <div class="day-box">
                <div class="day-label">{{ $dayName }} - {{ $dayFormatted }}</div>
                <div class="emoji-row">
                    <span class="emoji {{ in_array('happy', $maxMood) ? 'highlight' : '' }}">
                        <img src="{{ asset('images/happy.png') }}" alt="Happy">
                    </span>
                    <span class="emoji {{ in_array('neutral', $maxMood) ? 'highlight' : '' }}">
                        <img src="{{ asset('images/netral.png') }}" alt="Neutral">
                    </span>
                    <span class="emoji {{ in_array('sad', $maxMood) ? 'highlight' : '' }}">
                        <img src="{{ asset('images/sad.png') }}" alt="Sad">
                    </span>
                </div>
            </div>
        @endforeach
    </div>

</section>

        <section class="start-story-section">
            <h2 class="start-story-header">START YOUR STORY HERE!</h2>
            <div class="start-story-container">
                <div class="story-box">
                <ul>
                    <li><strong>1. Start writing</strong></li>
                    <p>All you have to do is start. Take 5 minutes to write in your journal about how you're feeling or reflect on the day.</p>
                </ul>
                </div>
                <div class="story-box">
                <ul>
                    <li><strong>2. Keep it going</strong></li>
                    <p>The more you write the easier it will be. Set reminders to keep a regular daily, weekly, or monthly cadence.</p>
                </ul>
                </div>
                <div class="story-box">
                <ul>
                    <li><strong>3. Be happy with u today</strong></li>
                    <p>You will get a quotes after wrtiing</p>
                </ul>
                </div>
            </div>
        </section>

        <footer class="footer">
            <div class="footer-left">
                <img src="{{ asset('images/emolog512.png') }}" alt="Emolog Logo" class="footer-logo">
                <span class="footer-title"></span>
            </div>

            <div class="footer-center">
                <h3>About Us</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            </div>

            <div class="footer-right">
                <h3>Contact Us</h3>
                <div class="contact-item">
                    <img src="{{ asset('images/email.png') }}" alt="Email Icon" class="contact-icon">
                    <a href="mailto:Emolog@gmail.com">Emolog@gmail.com</a>
                </div>
                <div class="contact-item">
                    <img src="{{ asset('images/insta.png') }}" alt="Instagram Icon" class="contact-icon">
                <a href="https://instagram.com/emolog" target="_blank">@emolog</a>
                </div>
            </div>
        </footer>

    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
