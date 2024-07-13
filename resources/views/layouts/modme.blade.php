<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        #terms {
            display: none;
        }

        .custom-form {
            border: 2px solid #241c1c;
            background-color: #f0f0f0;
            box-shadow: 0 4px 8px rgba(29, 24, 24, 0.2);
            padding: 20px;
            border-radius: 8px;
        }

        .form-check-input {
            appearance: none;
            width: 0.9em;
            height: 0.9em;
            border: 1px solid #adb5bd;
            border-radius: 0;
            display: inline-block;
            position: relative;
            cursor: pointer;
            margin-right: 0.5em;
        }

        .form-check-input:checked {
            background-color: #007bff;
            border-color: #007bff;
        }

        .form-check-input:checked::before {
            content: '';
            display: inline-block;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color:#fff;
            font-size: 1em;
        }

        .form-check-label {
            cursor: pointer;
        }

        * {
            border: 0;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #e3e4e8;
            --fg: #17181c;
            --primary: #255ff4;
            --yellow: #f4a825;
            --yellow-t: rgba(244, 168, 37, 0);
            --bezier: cubic-bezier(0.42,0,0.58,1);
            --trans-dur: 0.3s;
            font-size: calc(24px + (30 - 24) * (100vw - 320px) / (1280 - 320));
        }

        body {
            background-color: var(--bg);
            color: var(--fg);
            font: 1em/1.5 "DM Sans", sans-serif;
            display: flex;
            height: 100vh;
            transition: background-color var(--trans-dur), color var(--trans-dur);
        }

        .rating {
            margin: auto;
        }
        .rating__display {
            font-size: 1em;
            font-weight: 500;
            min-height: 1.25em;
            position: absolute;
            top: 100%;
            width: 100%;
            text-align: center;
        }
        .rating__stars {
            display: flex;
            padding-bottom: 0.375em;
            position: relative;
        }
        .rating__star {
            display: block;
            overflow: visible;
            pointer-events: none;
            width: 2em;
            height: 2em;
        }
        .rating__star-ring, .rating__star-fill, .rating__star-line, .rating__star-stroke {
            animation-duration: 1s;
            animation-timing-function: ease-in-out;
            animation-fill-mode: forwards;
        }
        .rating__star-ring, .rating__star-fill, .rating__star-line {
            stroke: var(--yellow);
        }
        .rating__star-fill {
            fill: var(--yellow);
            transform: scale(0);
            transition: fill var(--trans-dur) var(--bezier), transform var(--trans-dur) var(--bezier);
        }
        .rating__star-line {
            stroke-dasharray: 12 13;
            stroke-dashoffset: -13;
        }
        .rating__star-stroke {
            stroke: #c7cad1;
            transition: stroke var(--trans-dur);
        }
        .rating__label {
            cursor: pointer;
            padding: 0.125em;
        }
        .rating__label--delay1 .rating__star-ring, .rating__label--delay1 .rating__star-fill, .rating__label--delay1 .rating__star-line, .rating__label--delay1 .rating__star-stroke {
            animation-delay: 0.05s;
        }
        .rating__label--delay2 .rating__star-ring, .rating__label--delay2 .rating__star-fill, .rating__label--delay2 .rating__star-line, .rating__label--delay2 .rating__star-stroke {
            animation-delay: 0.1s;
        }
        .rating__label--delay3 .rating__star-ring, .rating__label--delay3 .rating__star-fill, .rating__label--delay3 .rating__star-line, .rating__label--delay3 .rating__star-stroke {
            animation-delay: 0.15s;
        }
        .rating__label--delay4 .rating__star-ring, .rating__label--delay4 .rating__star-fill, .rating__label--delay4 .rating__star-line, .rating__label--delay4 .rating__star-stroke {
            animation-delay: 0.2s;
        }
        .rating__input {
            position: absolute;
            -webkit-appearance: none;
            appearance: none;
        }
        .rating__input:hover ~ [data-rating]:not([hidden]) {
            display: none;
        }
        .rating__input-1:hover ~ [data-rating="1"][hidden], .rating__input-2:hover ~ [data-rating="2"][hidden], .rating__input-3:hover ~ [data-rating="3"][hidden], .rating__input-4:hover ~ [data-rating="4"][hidden], .rating__input-5:hover ~ [data-rating="5"][hidden], .rating__input:checked:hover ~ [data-rating]:not([hidden]) {
            display: block;
        }
        .rating__input-1:hover ~ .rating__label:first-of-type .rating__star-stroke, .rating__input-2:hover ~ .rating__label:nth-of-type(-n + 2) .rating__star-stroke, .rating__input-3:hover ~ .rating__label:nth-of-type(-n + 3) .rating__star-stroke, .rating__input-4:hover ~ .rating__label:nth-of-type(-n + 4) .rating__star-stroke, .rating__input-5:hover ~ .rating__label:nth-of-type(-n + 5) .rating__star-stroke {
            stroke: var(--yellow);
            transform: scale(1);
        }
        .rating__input-1:checked ~ .rating__label:first-of-type .rating__star-ring, .rating__input-2:checked ~ .rating__label:nth-of-type(-n + 2) .rating__star-ring, .rating__input-3:checked ~ .rating__label:nth-of-type(-n + 3) .rating__star-ring, .rating__input-4:checked ~ .rating__label:nth-of-type(-n + 4) .rating__star-ring, .rating__input-5:checked ~ .rating__label:nth-of-type(-n + 5) .rating__star-ring {
            animation-name: starRing;
        }
        .rating__input-1:checked ~ .rating__label:first-of-type .rating__star-stroke, .rating__input-2:checked ~ .rating__label:nth-of-type(-n + 2) .rating__star-stroke, .rating__input-3:checked ~ .rating__label:nth-of-type(-n + 3) .rating__star-stroke, .rating__input-4:checked ~ .rating__label:nth-of-type(-n + 4) .rating__star-stroke, .rating__input-5:checked ~ .rating__label:nth-of-type(-n + 5) .rating__star-stroke {
            animation-name: starStroke;
        }
        .rating__input-1:checked ~ .rating__label:first-of-type .rating__star-line, .rating__input-2:checked ~ .rating__label:nth-of-type(-n + 2) .rating__star-line, .rating__input-3:checked ~ .rating__label:nth-of-type(-n + 3) .rating__star-line, .rating__input-4:checked ~ .rating__label:nth-of-type(-n + 4) .rating__star-line, .rating__input-5:checked ~ .rating__label:nth-of-type(-n + 5) .rating__star-line {
            animation-name: starLine;
        }
        .rating__input-1:checked ~ .rating__label:first-of-type .rating__star-fill, .rating__input-2:checked ~ .rating__label:nth-of-type(-n + 2) .rating__star-fill, .rating__input-3:checked ~ .rating__label:nth-of-type(-n + 3) .rating__star-fill, .rating__input-4:checked ~ .rating__label:nth-of-type(-n + 4) .rating__star-fill, .rating__input-5:checked ~ .rating__label:nth-of-type(-n + 5) .rating__star-fill {
            animation-name: starFill;
        }
        .rating__input-1:not(:checked):hover ~ .rating__label:first-of-type .rating__star-fill, .rating__input-2:not(:checked):hover ~ .rating__label:nth-of-type(2) .rating__star-fill, .rating__input-3:not(:checked):hover ~ .rating__label:nth-of-type(3) .rating__star-fill, .rating__input-4:not(:checked):hover ~ .rating__label:nth-of-type(4) .rating__star-fill, .rating__input-5:not(:checked):hover ~ .rating__label:nth-of-type(5) .rating__star-fill {
            fill: var(--yellow-t);
        }
        .rating__sr {
            clip: rect(1px, 1px, 1px, 1px);
            overflow: hidden;
            position: absolute;
            width: 1px;
            height: 1px;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #17181c;
                --fg: #e3e4e8;
            }

            .rating {
                margin: auto;
            }
            .rating__star-stroke {
                stroke: #454954;
            }
        }
        @keyframes starRing {
            from, 20% {
                animation-timing-function: ease-in;
                opacity: 1;
                r: 8px;
                stroke-width: 16px;
                transform: scale(0);
            }
            35% {
                animation-timing-function: ease-out;
                opacity: 0.5;
                r: 8px;
                stroke-width: 16px;
                transform: scale(1);
            }
            50%, to {
                opacity: 0;
                r: 16px;
                stroke-width: 0;
                transform: scale(1);
            }
        }
        @keyframes starFill {
            from, 40% {
                animation-timing-function: ease-out;
                transform: scale(0);
            }
            60% {
                animation-timing-function: ease-in-out;
                transform: scale(1.2);
            }
            80% {
                transform: scale(0.9);
            }
            to {
                transform: scale(1);
            }
        }
        @keyframes starStroke {
            from {
                transform: scale(1);
            }
            20%, to {
                transform: scale(0);
            }
        }
        @keyframes starLine {
            from, 40% {
                animation-timing-function: ease-out;
                stroke-dasharray: 1 23;
                stroke-dashoffset: 1;
            }
            60%, to {
                stroke-dasharray: 12 13;
                stroke-dashoffset: -13;
            }
        }
    </style>
</head>
<body>

    <div class="container-fluid mt-5 p-4 m-4 ">
        <div class="container">

            @yield('content')

        </div>
    </div>

    {{-- Baholash uchun yulduzcha --}}
    <script>
        document.querySelectorAll('.rating__input').forEach(input => {
            input.addEventListener('change', function() {
                const ratingLabels = {
                    1: "Terrible",
                    2: "Bad",
                    3: "OK",
                    4: "Good",
                    5: "Excellent"
                };
                const ratingValue = this.value;
                const ratingLabel = ratingLabels[ratingValue];
                document.getElementById('rating-label').value = ratingLabel;
                this.form.submit();
            });
        });

        class StarRating {
            constructor(qs) {
                this.ratings = [
                    {id: 1, name: "Terrible"},
                    {id: 2, name: "Bad"},
                    {id: 3, name: "OK"},
                    {id: 4, name: "Good"},
                    {id: 5, name: "Excellent"}
                ];
                this.rating = null;
                this.el = document.querySelector(qs);

                this.init();
            }
            init() {
                this.el?.addEventListener("change", this.updateRating.bind(this));

                // stop Firefox from preserving form data between refreshes
                try {
                    this.el?.reset();
                } catch (err) {
                    console.error("Element isn’t a form.");
                }
            }
            updateRating(e) {
                // clear animation delays
                Array.from(this.el.querySelectorAll(`[for*="rating"]`)).forEach(el => {
                    el.className = "rating__label";
                });

                const ratingObject = this.ratings.find(r => r.id === +e.target.value);
                const prevRatingID = this.rating?.id || 0;

                let delay = 0;
                this.rating = ratingObject;
                this.ratings.forEach(rating => {
                    const { id } = rating;

                    // add the delays
                    const ratingLabel = this.el.querySelector(`[for="rating-${id}"]`);

                    if (id > prevRatingID + 1 && id <= this.rating.id) {
                        ++delay;
                        ratingLabel.classList.add(`rating__label--delay${delay}`);
                    }

                    // hide ratings to not read, show the one to read
                    const ratingTextEl = this.el.querySelector(`[data-rating="${id}"]`);

                    if (this.rating.id !== id)
                        ratingTextEl.setAttribute("hidden", true);
                    else
                        ratingTextEl.removeAttribute("hidden");
                });
            }
        }
    </script>


    {{-- Telegarm bot linkini ko'piya qilish --}}
    <script>
        function copyToClipboard(inputId, iconId, notificationId) {
            var inputElement = document.getElementById(inputId);
            inputElement.style.display = "block";
            inputElement.select();
            inputElement.setSelectionRange(0, 99999);
            document.execCommand("copy");
            inputElement.style.display = "none";

            var notification = document.getElementById(notificationId);
            notification.textContent = "";
            notification.style.display = "block";

            var copyIcon = document.getElementById(iconId);
            var originalIcon = copyIcon.innerHTML;
            copyIcon.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zM6.5 11l-2-2 1-1 1 1 3-3 1 1-4 4z"/>
                </svg>
            `;

            setTimeout(function() {
                notification.style.display = "none";
                copyIcon.innerHTML = originalIcon;
            }, 500);
        }
    </script>

    {{--  Tariff --}}
    <script>
        const checkboxes = document.querySelectorAll('.single-checkbox');
        const form = document.getElementById('tariffForm');
        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    checkboxes.forEach((cb) => {
                        if (cb !== this) cb.checked = false;
                    });
                    checkboxes.forEach((cb) => {
                        if (cb !== this) cb.required = false;
                    });
                } else {
                    const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                    if (!anyChecked) {
                        checkboxes.forEach((cb) => {
                            cb.required = true;
                        });
                    }
                }
            });
        });

        form.addEventListener('submit', function(event) {
            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
            if (!anyChecked) {
                alert("Iltimos, kamida bitta tarifni tanlang.");
                event.preventDefault();
            }
        });
    </script>

    <script>
        document.getElementById('showTerms').addEventListener('click', function() {
            var terms = document.getElementById('terms');
            if (terms.style.display === 'none' || terms.style.display === '') {
                terms.style.display = 'block';
            } else {
                terms.style.display = 'none';
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
