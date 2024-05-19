@extends('auth.requirements-registration')
@section('title', 'Pub Market Registration')
@section('content') 
<style>
    input[type=text]:focus, textarea:focus {
        width: 660px;
        border: none;
        border-bottom: 2px solid rgba(81, 203, 238, 1);
    }

    /* Popup container */
    .popup {
        display: none; /* Hidden by default */
        position: absolute; /* Positioned relative to the label */
        z-index: 1; /* Sit on top */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        padding: 1px;
        border-radius: 1px;
    }

        /* Popup content */
        .popup-content {
            background-color: #fefefe;
            padding: 10px;
            width: 200px; /* Smaller width */
            font-size: 14px;
        }

        .close {
            float: right;
            font-size: 14px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <div class="store">
        <div class="container-fluid">
            <form class="store-container" action="{{ route('updaterequirements') }}" method="post"
                  style="transform: translateY(clamp(10px, 20vh, 30vh));">
                @csrf
                <h1 class="headline">Let's give your store a <span>name</span></h1>
                <div class="input-container">
                    <label for="storename" class="visually-hidden">Store Name:</label>
                    <input class="storename" type="text" id="storename" name="storename" required>
                    <input type="hidden" name="requestdata" value="storename">
                    <button class="button-next" type="submit">NEXT</button>
                </div>
            </form>
        </div>
    </div>

    <!-- The Popup -->
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close" id="closePopup">&times;</span>
            <p>Example Store Name: T&J Store</p>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the popup
            var popup = document.getElementById("popup");

            // Get the <span> element that closes the popup
            var closePopup = document.getElementById("closePopup");

            // Get the input field
            var inputField = document.getElementById("storename");

            // When the user clicks on the input field, open the popup
            inputField.addEventListener("focus", function() {
                // Position the popup
                var rect = inputField.getBoundingClientRect();
                popup.style.top = (rect.top - popup.offsetHeight) + 'px';
                popup.style.left = rect.left + 'px';

                // Show the popup
                popup.style.display = "block";

                // Set a timer to close the popup after 3 seconds
                setTimeout(function() {
                    popup.style.display = "none";
                }, 3000);
            });

            // When the user clicks on <span> (x), close the popup
            closePopup.onclick = function() {
                popup.style.display = "none";
            }

            // When the user clicks anywhere outside of the popup, close it
            window.onclick = function(event) {
                if (event.target == popup) {
                    popup.style.display = "none";
                }
            }
        });
    </script>
@endsection

@push('scripts')
    @include('auth.registration-script')
@endpush
