<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Reminder - Today's Inspiration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-blue-600">
                            <i class="fas fa-sun mr-2"></i>Daily Reminder
                        </h1>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-200">
                            <i class="fas fa-cog mr-1"></i>Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($reminder)
            <!-- Daily Reminder Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-8 text-center">
                    <div class="flex items-center justify-center mb-4">
                        @if($reminder->category == 'motivation')
                            <i class="fas fa-rocket fa-3x"></i>
                        @elseif($reminder->category == 'reflection')
                            <i class="fas fa-brain fa-3x"></i>
                        @elseif($reminder->category == 'self-discipline')
                            <i class="fas fa-dumbbell fa-3x"></i>
                        @else
                            <i class="fas fa-star fa-3x"></i>
                        @endif
                    </div>
                    <h2 class="text-3xl font-bold mb-2">Today's Daily Reminder</h2>
                    <p class="text-blue-100">{{ now()->format('l, F j, Y') }}</p>
                </div>

                <!-- Card Body -->
                <div class="p-8">
                    <div class="text-center">
                        <!-- Category Badge -->
                        @if($reminder->category)
                            <div class="mb-6">
                                @if($reminder->category == 'motivation')
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-rocket mr-2"></i>{{ ucfirst($reminder->category) }}
                                    </span>
                                @elseif($reminder->category == 'reflection')
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-brain mr-2"></i>{{ ucfirst($reminder->category) }}
                                    </span>
                                @elseif($reminder->category == 'self-discipline')
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-dumbbell mr-2"></i>{{ ucfirst($reminder->category) }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                        <i class="fas fa-star mr-2"></i>{{ ucfirst($reminder->category) }}
                                    </span>
                                @endif
                            </div>
                        @endif

                        <!-- Reminder Message -->
                        <div class="mb-8">
                            <blockquote class="text-2xl md:text-3xl font-medium text-gray-900 leading-relaxed">
                                <i class="fas fa-quote-left text-blue-300 text-lg mr-2"></i>
                                {{ $reminder->message }}
                                <i class="fas fa-quote-right text-blue-300 text-lg ml-2"></i>
                            </blockquote>
                        </div>

                        <!-- Date Info -->
                        <div class="text-sm text-gray-500 mb-6">
                            @if($reminder->scheduled_date)
                                <i class="fas fa-calendar-alt mr-1"></i>
                                Scheduled for: {{ \Carbon\Carbon::parse($reminder->scheduled_date)->format('F j, Y') }}
                            @else
                                <i class="fas fa-infinity mr-1"></i>
                                General reminder
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <button onclick="shareReminder()" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition duration-200">
                                <i class="fas fa-share mr-2"></i>Share
                            </button>
                            <button onclick="shuffleReminder()" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-200">
                                <i class="fas fa-random mr-2"></i>Shuffle
                            </button>
                            <button onclick="copyReminder()" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-200">
                                <i class="fas fa-copy mr-2"></i>Copy
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 transition duration-200">
                                <i class="fas fa-plus mr-2"></i>Add New
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    <i class="fas fa-info-circle mr-1"></i>
                    Admins can create and schedule new reminders through the admin panel.
                </p>
            </div>

        @else
            <!-- No Reminder Available -->
            <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                <div class="mb-6">
                    <i class="fas fa-inbox fa-4x text-gray-300"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">No Reminder Available</h2>
                <p class="text-lg text-gray-600 mb-8">
                    There are no reminders set up yet. Add your first reminder to get started!
                </p>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-plus mr-2"></i>Create First Reminder
                </a>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-16">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-500">
                    <i class="fas fa-heart text-red-500 mr-1"></i>
                    Daily Reminder - Inspiring you every day
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for interactions -->
    <script>
        function shareReminder() {
            const reminderText = "{{ $reminder ? $reminder->message : '' }}";
            const shareText = `Today's Daily Reminder: "${reminderText}"`;
            
            if (navigator.share) {
                navigator.share({
                    title: 'Daily Reminder',
                    text: shareText
                });
            } else {
                copyToClipboard(shareText);
                showNotification('Reminder copied to clipboard!');
            }
        }

        function shuffleReminder() {
            // Add a random parameter to force page refresh with new random reminder
            const randomParam = Math.random().toString(36).substring(2, 15);
            const currentUrl = new URL(window.location);
            currentUrl.searchParams.set('shuffle', randomParam);
            window.location.href = currentUrl.toString();
        }

        function copyReminder() {
            const reminderText = "{{ $reminder ? $reminder->message : '' }}";
            copyToClipboard(reminderText);
            showNotification('Reminder copied to clipboard!');
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                showNotification('Copied to clipboard!');
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }

        function showNotification(message) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-transform duration-300 translate-x-full';
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Auto-refresh page every 5 minutes to check for new content
        setTimeout(() => {
            window.location.reload();
        }, 5 * 60 * 1000);
    </script>
</body>
</html>
