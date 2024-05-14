<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Food Store</title>
    <link href="{{mix('css/app.css')}}" rel="stylesheet">
    <style>
        /* Center the modal */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            position: relative;
        }
        .close {
            position: absolute;
            top: 0;
            right: 0;
            padding: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<header>
    <div class="container">
        @include('layouts.header')
    </div>
</header>
<div class="container">
    <div class="row">
        <!-- <div class="col-lg-2 col-md-3 sidebar-div">
            @include('layouts.sidebar')
        </div> -->
        <div class="col-lg-12">
        @if(session('error'))
                <!-- The Modal -->
                <div id="myModal" class="modal">
                    <!-- Modal content -->
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
                <script>
                    // Get the modal
                    var modal = document.getElementById('myModal');

                    // Get the close button
                    var closeBtn = document.getElementsByClassName("close")[0];

                    // Close the modal when the close button is clicked
                    closeBtn.onclick = function() {
                        modal.style.display = "none";
                    }

                    // Close the modal when the user clicks anywhere outside of it
                    window.onclick = function(event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }

                    // Show the modal
                    modal.style.display = "block";
                </script>
            @endif
            @yield('content')
        </div>
    </div>
</div>
<footer>
</footer>
<script src="{{ mix('js/app.js') }}" defer></script>
<script>
        function toggleDiscountAmount() {
            const type = document.getElementById('type').value;
            const discountAmountDiv = document.getElementById('discountAmountDiv');
            const discountAmountInput = document.getElementById('discount_amount');
            if (type === 'magical') {
                discountAmountDiv.style.display = 'none';
                discountAmountInput.value = '';
                discountAmountInput.removeAttribute('required');
            } else {
                discountAmountDiv.style.display = 'block';
                discountAmountInput.setAttribute('required', 'required');
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            toggleDiscountAmount(); // Run this on page load to set initial state
        });
</script>
</body>
</html>