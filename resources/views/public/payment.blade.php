<div class="card-body p-4 p-lg-5">
    @if(session('success'))
        <div id="booking-success-alert" class="booking-success-alert">
            <div class="booking-success-icon">✓</div>
            <div class="booking-success-text">
                {{ session('success') }}
            </div>
        </div>

        <style>
            .booking-success-alert {
                display: flex;
                align-items: center;
                gap: 12px;
                background: #f8fffb;
                border: 1px solid #d9f5e4;
                border-radius: 16px;
                padding: 16px 20px;
                margin-bottom: 24px;
                animation: fadeIn 0.4s ease;
            }

            .booking-success-icon {
                width: 34px;
                height: 34px;
                border-radius: 50%;
                background: #22c55e;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
                font-size: 14px;
                flex-shrink: 0;
            }

            .booking-success-text {
                color: #1f2937;
                font-size: 15px;
                font-weight: 500;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-8px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>

        <script>
            setTimeout(() => {
                const alert = document.getElementById('booking-success-alert');
                if(alert){
                    alert.style.transition = '0.4s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 400);
                }
            }, 3000);
        </script>
@endif
