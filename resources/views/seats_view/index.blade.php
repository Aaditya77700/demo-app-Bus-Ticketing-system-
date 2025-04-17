<!-- Seat Selection Interface with Enhanced Design -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Booking System</title>
    
    <!-- Import Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Optional: If you want to use a specific version -->
    <!-- <script src="https://cdn.tailwindcss.com?v=3.3.5"></script> -->
</head>
@php
    $seatsPerRow = 4;
    $chunks = $seats->chunk($seatsPerRow);
@endphp
<!-- Bus Front (Driver Section) -->
<div class="flex justify-between items-center mb-6">
    <div class="flex items-center space-x-2 text-gray-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        <span class="font-semibold">Windshield</span>
    </div>
    <div class="flex items-center bg-gray-700 text-white px-4 py-2 rounded-lg shadow-inner">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path d="M4 5h12M4 10h12M4 15h12" />
        </svg>
        Driver Seat
    </div>
</div>

<!-- Bus Seat Layout -->
<div class="space-y-5">
    @foreach($chunks as $i => $row)
        <div class="flex justify-center items-center space-x-10">
            <!-- Left Side Seats -->
            <div class="flex space-x-5">
                @foreach($row->slice(0, 2) as $seat)
                    @php
                        $isBooked = in_array($seat->seat_number, $bookedSeatNumbers);
                        $seatColor = $isBooked 
                            ? 'bg-red-400 text-white cursor-not-allowed' 
                            : 'bg-green-500 text-white hover:bg-green-600 hover:scale-105 hover:shadow-lg transition';
                    @endphp
                    <button
                        type="button"
                        data-seat-id="{{ $seat->id }}"
                        data-seat-number="{{ $seat->seat_number }}"
                        {{ $isBooked ? 'disabled' : '' }}
                        class="seat-btn w-16 h-20 rounded-xl font-bold text-lg flex items-center justify-center {{ $seatColor }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 6v10H5a1 1 0 100 2h14a1 1 0 100-2h-2V6a4 4 0 00-8 0z"/>
                        </svg>
                        {{ $seat->seat_number }}
                    </button>
                @endforeach
            </div>

            <!-- Aisle -->
            <div class="w-8 sm:w-12 border-l-4 border-dashed border-gray-300 h-20"></div>

            <!-- Right Side Seats -->
            <div class="flex space-x-5">
                @foreach($row->slice(2) as $seat)
                    @php
                        $isBooked = in_array($seat->seat_number, $bookedSeatNumbers);
                        $seatColor = $isBooked 
                            ? 'bg-red-400 text-white cursor-not-allowed' 
                            : 'bg-green-500 text-white hover:bg-green-600 hover:scale-105 hover:shadow-lg transition';
                    @endphp
                    <button
                        type="button"
                        data-seat-id="{{ $seat->id }}"
                        data-seat-number="{{ $seat->seat_number }}"
                        {{ $isBooked ? 'disabled' : '' }}
                        class="seat-btn w-16 h-20 rounded-xl font-bold text-lg flex items-center justify-center {{ $seatColor }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 6v10H5a1 1 0 100 2h14a1 1 0 100-2h-2V6a4 4 0 00-8 0z"/>
                        </svg>
                        {{ $seat->seat_number }}
                    </button>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<!-- Row Legend & Info -->
<div class="mt-8 p-4 bg-blue-50 rounded-xl border border-blue-200 flex items-center justify-between">
    <div class="flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="font-medium text-gray-700" id="selectedSeatDisplay">Selected Seat: 
            <span class="text-blue-600 font-bold">None</span>
        </p>
    </div>
    <div class="flex space-x-4">
        <span class="w-5 h-5 rounded bg-green-500 inline-block"></span><span>Available</span>
        <span class="w-5 h-5 rounded bg-red-400 inline-block"></span><span>Booked</span>
    </div>
</div>


        <!-- Booking Form Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 mb-8">
            <!-- Card Header with Color Band -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4 text-white">
                <h3 class="text-xl font-bold">Passenger Details</h3>
            </div>
            
            <!-- Form Content -->
            <div class="p-6">
                <form method="POST" action="{{ route('seats.book') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter your full name" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="text" name="phone" id="phone" placeholder="Enter your phone number" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <input type="hidden" name="seat_id" id="selectedSeatId">
                    
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-md text-center transition duration-300 ease-in-out flex items-center justify-center mt-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        Confirm Booking
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-6 mb-8">
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h4 class="text-lg font-medium text-green-800">Booking Successful!</h4>
                        <p class="mt-1 text-green-700">{{ session('success') }}</p>
                        @if (session('ticket'))
                            <a href="{{ session('ticket') }}" class="mt-3 inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md shadow-sm transition duration-300 ease-in-out" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                                Download Ticket PDF
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Back Button -->
        <div class="text-center">
            <a href="{{ route('buses_view.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                Back to Bus Listing
            </a>
        </div>
    </div>
</div>

<!-- Script to Select Seat -->
<script>


document.querySelectorAll('.seat-btn').forEach(button => {
        button.addEventListener('click', function () {
            document.querySelectorAll('.seat-btn').forEach(b => b.classList.remove('bg-blue-500'));
            this.classList.add('bg-blue-500');
            document.getElementById('selectedSeatDisplay').querySelector('span').innerText = this.dataset.seatNumber;
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const seatButtons = document.querySelectorAll('.seat-btn');
        let selectedButton = null;
        
        seatButtons.forEach(button => {
            if (!button.disabled) {
                button.addEventListener('click', function() {
                    // Reset previously selected button
                    if (selectedButton) {
                        selectedButton.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                        selectedButton.classList.add('bg-green-500', 'hover:bg-green-600');
                    }
                    
                    // Update current selection
                    selectedButton = this;
                    this.classList.remove('bg-green-500', 'hover:bg-green-600');
                    this.classList.add('bg-blue-500', 'hover:bg-blue-600');
                    
                    const seatId = this.getAttribute('data-seat-id');
                    const seatNumber = this.getAttribute('data-seat-number');
                    
                    document.getElementById('selectedSeatId').value = seatId;
                    document.getElementById('selectedSeatDisplay').innerHTML = 'Selected Seat: <span class="text-blue-600 font-bold">' + seatNumber + '</span>';
                });
            }
        });
    });
</script>