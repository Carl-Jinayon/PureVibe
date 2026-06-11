<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>PureVibe Kiosk</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --accent: #7c3aed;
            --bg-color: #f8fafc;
            --card-bg: rgba(255, 255, 255, 0.9);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            background-image: linear-gradient(135deg, rgba(79, 70, 229, 0.05) 0%, rgba(124, 58, 237, 0.05) 100%);
            height: 100vh;
            margin: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Layout */
        .kiosk-container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        .main-section {
            flex: 0 0 70%;
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 1.5rem;
            overflow: hidden;
        }

        .cart-section {
            flex: 0 0 30%;
            height: 100%;
            background: white;
            box-shadow: -4px 0 15px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            z-index: 10;
        }

        /* Header */
        .kiosk-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            padding: 1rem 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        .store-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .clock-display {
            text-align: right;
            font-variant-numeric: tabular-nums;
        }

        /* Search & Categories */
        .controls-wrapper {
            margin-bottom: 1rem;
        }

        .search-bar {
            background: white;
            border-radius: 12px;
            padding: 0.5rem 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .search-bar input {
            border: none;
            outline: none;
            width: 100%;
            padding: 0.5rem;
            font-size: 1.1rem;
            background: transparent;
        }

        .search-bar i {
            color: #94a3b8;
            font-size: 1.2rem;
        }

        .categories-scroll {
            display: flex;
            gap: 0.75rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        
        .categories-scroll::-webkit-scrollbar {
            display: none;
        }

        .cat-pill {
            background: white;
            border: 1px solid #e2e8f0;
            padding: 0.6rem 1.2rem;
            border-radius: 20px;
            white-space: nowrap;
            cursor: pointer;
            font-weight: 500;
            color: #475569;
            transition: all 0.2s;
            user-select: none;
        }

        .cat-pill.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
        }

        /* Product Grid */
        .product-scroll-area {
            flex: 1;
            overflow-y: auto;
            padding-right: 0.5rem;
            padding-bottom: 2rem;
        }

        /* Custom Scrollbar */
        .product-scroll-area::-webkit-scrollbar,
        .cart-items-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .product-scroll-area::-webkit-scrollbar-track,
        .cart-items-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .product-scroll-area::-webkit-scrollbar-thumb,
        .cart-items-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
        }

        .product-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1rem;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }

        .product-img-wrapper {
            aspect-ratio: 1;
            background: #f1f5f9;
            border-radius: 12px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .product-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-img-wrapper i {
            font-size: 3rem;
            color: #94a3b8;
        }

        .stock-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stock-badge.in-stock { color: #16a34a; }
        .stock-badge.in-stock::before {
            content: '';
            width: 6px;
            height: 6px;
            background: #16a34a;
            border-radius: 50%;
        }

        .stock-badge.out-stock { color: #dc2626; }
        .stock-badge.out-stock::before {
            content: '';
            width: 6px;
            height: 6px;
            background: #dc2626;
            border-radius: 50%;
        }

        .product-name {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.25rem;
            font-size: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex-grow: 1;
        }

        .product-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .btn-add-cart {
            background: #f1f5f9;
            color: var(--primary);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.2s;
            width: 100%;
        }

        .btn-add-cart:hover:not(:disabled) {
            background: var(--primary);
            color: white;
        }

        .btn-add-cart:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Cart Section */
        .cart-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-header h2 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .cart-badge {
            background: var(--accent);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .cart-items-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
        }

        .cart-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 12px;
            margin-bottom: 1rem;
            position: relative;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .cart-item-img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
        }
        
        .cart-item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-title {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.25rem;
            padding-right: 20px;
        }

        .cart-item-price {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .qty-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: white;
            border-radius: 8px;
            padding: 0.25rem;
            width: fit-content;
            border: 1px solid #e2e8f0;
        }

        .qty-btn {
            border: none;
            background: transparent;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #475569;
            transition: background 0.2s;
        }

        .qty-btn:hover {
            background: #f1f5f9;
        }

        .qty-input {
            width: 30px;
            text-align: center;
            border: none;
            background: transparent;
            font-weight: 600;
            padding: 0;
            -moz-appearance: textfield;
        }
        .qty-input::-webkit-outer-spin-button,
        .qty-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .btn-remove {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: transparent;
            border: none;
            color: #ef4444;
            padding: 0.25rem;
            cursor: pointer;
            opacity: 0.5;
            transition: opacity 0.2s;
        }

        .btn-remove:hover {
            opacity: 1;
        }

        .cart-footer {
            padding: 1.5rem;
            background: white;
            border-top: 1px solid #e2e8f0;
            box-shadow: 0 -4px 6px -1px rgba(0,0,0,0.02);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            color: #475569;
        }

        .summary-row.total {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 1.5rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px dashed #e2e8f0;
        }

        .btn-checkout {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            border: none;
            border-radius: 12px;
            padding: 1.25rem;
            width: 100%;
            font-size: 1.25rem;
            font-weight: 700;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.2s;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
        }

        .btn-checkout:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
        }

        .btn-checkout:disabled {
            background: #cbd5e1;
            box-shadow: none;
            cursor: not-allowed;
            transform: none;
        }

        .btn-clear-cart {
            width: 100%;
            background: transparent;
            border: none;
            color: #ef4444;
            padding: 0.75rem;
            font-weight: 600;
            margin-top: 0.5rem;
            border-radius: 8px;
        }

        .btn-clear-cart:hover {
            background: #fef2f2;
        }

        /* Modal Styles */
        .modal-backdrop.show {
            opacity: 0.7;
            background-color: #0f172a;
        }
        
        .receipt-modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        }

        .receipt-body {
            padding: 2rem;
            font-family: 'Courier New', Courier, monospace;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 2rem;
            border-bottom: 1px dashed #cbd5e1;
            padding-bottom: 1rem;
        }

        .receipt-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .receipt-total {
            border-top: 1px dashed #cbd5e1;
            margin-top: 1rem;
            padding-top: 1rem;
            font-weight: bold;
        }

        /* Skeleton Loader */
        .skeleton {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .product-grid { grid-template-columns: repeat(3, 1fr); }
            .main-section { flex: 0 0 65%; }
            .cart-section { flex: 0 0 35%; }
        }

        @media (max-width: 768px) {
            .kiosk-container { flex-direction: column; }
            .main-section { flex: 1; height: auto; overflow: visible; }
            .cart-section { 
                flex: none; 
                height: auto; 
                position: fixed; 
                bottom: 0; 
                left: 0; 
                width: 100%; 
                max-height: 80vh;
                border-radius: 20px 20px 0 0;
                transform: translateY(calc(100% - 80px));
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .cart-section.expanded {
                transform: translateY(0);
            }
            .cart-toggle-mobile {
                display: flex !important;
                justify-content: space-between;
                align-items: center;
                padding: 1rem 1.5rem;
                background: var(--primary);
                color: white;
                border-radius: 20px 20px 0 0;
                cursor: pointer;
            }
            .cart-header { display: none; }
            .product-grid { grid-template-columns: repeat(2, 1fr); }
            body { overflow-y: auto; height: auto; }
            .product-scroll-area { overflow: visible; padding-bottom: 100px; }
        }

        .cart-toggle-mobile { display: none; }

        /* =============================================
           IDLE / WELCOME SCREEN
        ============================================= */
        #idleScreen {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: linear-gradient(145deg, #0f0c29, #302b63, #24243e);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: opacity 0.6s ease, visibility 0.6s ease;
            overflow: hidden;
        }

        #idleScreen.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        /* Animated background particles */
        .idle-bg-orb {
            position: absolute;
            border-radius: 50%;
            opacity: 0.15;
            filter: blur(80px);
            animation: orbFloat 8s ease-in-out infinite alternate;
        }
        .idle-bg-orb:nth-child(1) {
            width: 500px; height: 500px;
            background: var(--primary);
            top: -100px; left: -100px;
            animation-delay: 0s;
        }
        .idle-bg-orb:nth-child(2) {
            width: 400px; height: 400px;
            background: var(--accent);
            bottom: -80px; right: -80px;
            animation-delay: -3s;
        }
        .idle-bg-orb:nth-child(3) {
            width: 300px; height: 300px;
            background: #06b6d4;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -5s;
        }

        @keyframes orbFloat {
            0% { transform: scale(1) translate(0, 0); }
            100% { transform: scale(1.15) translate(20px, -20px); }
        }

        .idle-content {
            position: relative;
            text-align: center;
            color: white;
            padding: 2rem;
            user-select: none;
        }

        .idle-logo-ring {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            box-shadow: 0 0 60px rgba(79, 70, 229, 0.6), 0 0 120px rgba(124, 58, 237, 0.3);
            animation: logoPulse 2s ease-in-out infinite;
        }

        @keyframes logoPulse {
            0%, 100% { box-shadow: 0 0 60px rgba(79, 70, 229, 0.6), 0 0 120px rgba(124, 58, 237, 0.3); transform: scale(1); }
            50% { box-shadow: 0 0 80px rgba(79, 70, 229, 0.9), 0 0 160px rgba(124, 58, 237, 0.5); transform: scale(1.05); }
        }

        .idle-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #ffffff, #c4b5fd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .idle-subtitle {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.6);
            margin-bottom: 3rem;
            font-weight: 400;
        }

        .idle-tap-cta {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50px;
            padding: 1.1rem 2.5rem;
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
            animation: tapBounce 2.5s ease-in-out infinite;
        }

        @keyframes tapBounce {
            0%, 100% { transform: translateY(0); box-shadow: 0 4px 30px rgba(0,0,0,0.2); }
            50% { transform: translateY(-8px); box-shadow: 0 16px 40px rgba(0,0,0,0.3); }
        }

        .idle-tap-cta i {
            font-size: 1.5rem;
            animation: fingerTap 1.5s ease-in-out infinite;
        }

        @keyframes fingerTap {
            0%, 60%, 100% { transform: scale(1); }
            30% { transform: scale(0.8); }
        }

        .idle-clock {
            position: absolute;
            top: 2rem;
            right: 2.5rem;
            text-align: right;
            color: rgba(255,255,255,0.7);
        }

        .idle-clock-time {
            font-size: 2rem;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
            line-height: 1;
        }

        .idle-clock-date {
            font-size: 0.85rem;
            margin-top: 0.25rem;
            opacity: 0.7;
        }

        .idle-footer {
            position: absolute;
            bottom: 1.5rem;
            left: 0; right: 0;
            text-align: center;
            color: rgba(255,255,255,0.3);
            font-size: 0.8rem;
        }

        /* =============================================
           THANK YOU / COMPLETION SCREEN
        ============================================= */
        #completionScreen {
            position: fixed;
            inset: 0;
            z-index: 9998;
            background: linear-gradient(145deg, #0f2027, #203a43, #2c5364);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease, visibility 0.5s ease;
            overflow: hidden;
        }

        #completionScreen.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .completion-orb {
            position: absolute;
            border-radius: 50%;
            opacity: 0.12;
            filter: blur(70px);
        }
        .completion-orb:nth-child(1) {
            width: 600px; height: 600px;
            background: #10b981;
            top: -150px; right: -150px;
        }
        .completion-orb:nth-child(2) {
            width: 400px; height: 400px;
            background: #6366f1;
            bottom: -100px; left: -100px;
        }

        .completion-content {
            position: relative;
            text-align: center;
            color: white;
            padding: 2rem;
            max-width: 600px;
            width: 100%;
        }

        .completion-check {
            width: 110px;
            height: 110px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5);
            animation: successPing 1.5s ease-out 1;
        }

        @keyframes successPing {
            0% { transform: scale(0.5); opacity: 0; box-shadow: 0 0 0 0 rgba(16,185,129,0.7); }
            50% { transform: scale(1.1); }
            70% { box-shadow: 0 0 0 40px rgba(16,185,129,0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(16,185,129,0); opacity: 1; }
        }

        .completion-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #ffffff, #6ee7b7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .completion-subtitle {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.65);
            margin-bottom: 2rem;
        }

        /* Countdown Timer Ring */
        .timer-ring-wrapper {
            position: relative;
            width: 140px;
            height: 140px;
            margin: 0 auto 2rem;
        }

        .timer-ring-svg {
            transform: rotate(-90deg);
            width: 140px;
            height: 140px;
        }

        .timer-ring-track {
            fill: none;
            stroke: rgba(255,255,255,0.1);
            stroke-width: 8;
        }

        .timer-ring-progress {
            fill: none;
            stroke: url(#timerGradient);
            stroke-width: 8;
            stroke-linecap: round;
            transition: stroke-dashoffset 1s linear;
        }

        .timer-ring-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .timer-count {
            font-size: 2.2rem;
            font-weight: 800;
            color: white;
            line-height: 1;
            font-variant-numeric: tabular-nums;
        }

        .timer-label {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.5);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-top: 4px;
        }

        .completion-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-completion-print {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.9rem 2rem;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 50px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .btn-completion-print:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        .btn-completion-new {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.9rem 2rem;
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            border-radius: 50px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-completion-new:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.6);
        }

        .completion-receipt-preview {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: left;
            font-family: 'Courier New', Courier, monospace;
            font-size: 0.85rem;
            color: rgba(255,255,255,0.8);
            max-height: 220px;
            overflow-y: auto;
        }

        .completion-receipt-preview::-webkit-scrollbar {
            width: 4px;
        }
        .completion-receipt-preview::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 4px;
        }
    </style>
</head>
<body>

    <!-- ===== IDLE / WELCOME SCREEN ===== -->
    <div id="idleScreen" onclick="dismissIdleScreen()">
        <!-- Background orbs -->
        <div class="idle-bg-orb"></div>
        <div class="idle-bg-orb"></div>
        <div class="idle-bg-orb"></div>

        <!-- Clock -->
        <div class="idle-clock">
            <div class="idle-clock-time" id="idleClockTime">00:00</div>
            <div class="idle-clock-date" id="idleClockDate"></div>
        </div>

        <!-- Main content -->
        <div class="idle-content">
            <div class="idle-logo-ring">
                <i class="bi bi-shop"></i>
            </div>
            <div class="idle-title">PureVibe</div>
            <div id="idleSubtitle" class="idle-subtitle">Self-Checkout Kiosk — Fast &amp; Easy</div>
            <div class="idle-tap-cta">
                <i id="idleCtaIcon" class="bi bi-hand-index-thumb"></i>
                <span id="idleCtaText">Tap anywhere to start your order</span>
            </div>
            <!-- Shown only when resuming an order -->
            <div id="idleCartBadge" style="display:none; margin-top:1.25rem;">
                <span style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.25); border-radius:50px; padding:0.5rem 1.25rem; font-size:0.9rem; color:rgba(255,255,255,0.85);">
                    <i class="bi bi-cart3 me-1"></i>
                    <span id="idleCartCount"></span>
                </span>
            </div>
        </div>

        <div class="idle-footer">
            {{ $settings['store_name'] ?? 'PureVibe' }} &mdash; Powered by Self-Checkout
        </div>
    </div>

    <!-- ===== THANK YOU / COMPLETION SCREEN ===== -->
    <div id="completionScreen" class="hidden">
        <!-- Background orbs -->
        <div class="completion-orb"></div>
        <div class="completion-orb"></div>

        <div class="completion-content">
            <!-- Animated check -->
            <div class="completion-check" id="completionCheck">
                <i class="bi bi-check-lg"></i>
            </div>

            <div class="completion-title">Thank You!</div>
            <div class="completion-subtitle">Your order has been confirmed &amp; is being prepared.</div>

            <!-- Receipt mini preview -->
            <div class="completion-receipt-preview" id="completionReceiptText">
                <!-- Populated by JS -->
            </div>

            <!-- Countdown ring -->
            <div class="timer-ring-wrapper">
                <svg class="timer-ring-svg" viewBox="0 0 140 140">
                    <defs>
                        <linearGradient id="timerGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#10b981"/>
                            <stop offset="100%" stop-color="#6366f1"/>
                        </linearGradient>
                    </defs>
                    <circle class="timer-ring-track" cx="70" cy="70" r="58"/>
                    <circle class="timer-ring-progress" id="timerRingProgress" cx="70" cy="70" r="58"
                        stroke-dasharray="364.425"
                        stroke-dashoffset="0"/>
                </svg>
                <div class="timer-ring-center">
                    <div class="timer-count" id="timerCount">30</div>
                    <div class="timer-label">seconds</div>
                </div>
            </div>

            <!-- Actions -->
            <div class="completion-actions">
                <button class="btn-completion-print" id="btnCompletionPrint" onclick="completionPrintReceipt()">
                    <i class="bi bi-printer"></i> Print Receipt
                </button>
                <button class="btn-completion-new" onclick="resetToIdle()">
                    <i class="bi bi-arrow-repeat"></i> Next Customer
                </button>
            </div>
        </div>
    </div>

    <div class="kiosk-container">
        <!-- Main Product Section -->
        <div class="main-section">
            <!-- Header -->
            <div class="kiosk-header">
                <div class="store-brand">
                    <div class="brand-icon">
                        <i class="bi bi-shop"></i>
                    </div>
                    <div>
                        <h1 class="h5 mb-0 fw-bold">PureVibe</h1>
                        <small class="text-muted">Self-Checkout Kiosk</small>
                    </div>
                </div>
                <div class="clock-display">
                    <div id="clock-time" class="h4 mb-0 fw-bold text-dark">00:00</div>
                    <div id="clock-date" class="small text-muted">Loading date...</div>
                </div>
            </div>

            <!-- Controls -->
            <div class="controls-wrapper">
                <div class="search-bar">
                    <i class="bi bi-search me-2"></i>
                    <input type="text" id="searchInput" placeholder="Search products by name or barcode...">
                </div>

                <div class="categories-scroll" id="categoriesContainer">
                    <div class="cat-pill active" data-id="">All Items</div>
                    @if(isset($categories))
                        @foreach($categories as $category)
                            <div class="cat-pill" data-id="{{ $category->id }}">{{ $category->name }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Product Grid -->
            <div class="product-scroll-area">
                <div class="product-grid" id="productGrid">
                    <!-- Products rendered via JS -->
                </div>
                
                <div id="loadingState" class="text-center py-5 d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div id="emptyState" class="text-center py-5 d-none">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <h3 class="mt-3 text-muted">No products found</h3>
                    <p class="text-muted">Try adjusting your search or category filter.</p>
                </div>
            </div>
        </div>

        <!-- Cart Section -->
        <div class="cart-section" id="cartSection">
            <div class="cart-toggle-mobile" id="mobileCartToggle">
                <div class="fw-bold fs-5">
                    <i class="bi bi-cart3 me-2"></i> Your Cart (<span id="mobileItemCount">0</span>)
                </div>
                <div class="fw-bold fs-5" id="mobileTotal">₱0.00</div>
            </div>

            <div class="cart-header">
                <h2>Your Cart</h2>
                <span class="cart-badge" id="cartBadge">0 items</span>
            </div>

            <div class="cart-items-scroll" id="cartItemsList">
                <!-- Cart Items Rendered via JS -->
                <div class="text-center py-5 text-muted" id="emptyCartMessage">
                    <i class="bi bi-cart-x mb-3 d-block" style="font-size: 3rem;"></i>
                    Your cart is empty
                </div>
            </div>

            <div class="cart-footer">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="subtotalAmount">₱0.00</span>
                </div>
                <div class="summary-row">
                    <span>{{ $settings['tax_name'] ?? 'VAT' }} ({{ $settings['default_tax_rate'] ?? 12 }}%)</span>
                    <span id="taxAmount">₱0.00</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span id="totalAmount">₱0.00</span>
                </div>

                <button class="btn-checkout" id="checkoutBtn" disabled>
                    <span>Checkout</span>
                    <i class="bi bi-arrow-right-circle-fill"></i>
                </button>
                <button class="btn-clear-cart" id="clearCartBtn" style="display: none;">
                    Clear Cart
                </button>
            </div>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div class="modal fade" id="receiptModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content receipt-modal-content">
                <div class="modal-body receipt-body" id="receiptContent">
                    <!-- Receipt content populated by JS -->
                </div>
                <div class="modal-footer border-0 p-4 pt-0 justify-content-between">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" onclick="printReceipt()">
                        <i class="bi bi-printer me-2"></i>Print
                    </button>
                    <button type="button" class="btn btn-primary px-4 py-2" style="background: var(--primary); border: none;" onclick="startNewTransaction()">
                        New Transaction <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Waiting for Admin Confirmation Modal -->
    <div class="modal fade" id="waitingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 24px; border: none; text-align: center; padding: 2.5rem 2rem; background: rgba(255,255,255,0.97); box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
                <div class="modal-body p-0">
                    <div class="mb-4">
                        <div class="spinner-border" style="width: 4.5rem; height: 4.5rem; color: var(--primary); border-width: 5px;" role="status"></div>
                    </div>
                    <h3 class="fw-bold mb-2" style="color: var(--primary);">Order Placed!</h3>
                    <p class="text-muted mb-1 fs-5">Waiting for admin confirmation...</p>
                    <p class="text-muted small mb-3">Transaction <strong id="pendingTxnNumber"></strong> has been received.</p>
                    <div class="d-flex align-items-center justify-content-center gap-2 mt-3 p-3 rounded-3" style="background: #fff8e1;">
                        <i class="bi bi-clock-history fs-5 text-warning"></i>
                        <span class="fw-semibold text-warning">Pending Admin Confirmation</span>
                    </div>
                    <p class="text-muted small mt-3 mb-0">Please wait. The receipt will appear automatically once confirmed.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // --- State ---
        let cart = [];
        let currentCategoryId = '';
        let currentSearch = '';
        let isFetching = false;
        
        // --- DOM Elements ---
        const productGrid = document.getElementById('productGrid');
        const loadingState = document.getElementById('loadingState');
        const emptyState = document.getElementById('emptyState');
        const searchInput = document.getElementById('searchInput');
        const catPills = document.querySelectorAll('.cat-pill');
        const cartItemsList = document.getElementById('cartItemsList');
        const emptyCartMessage = document.getElementById('emptyCartMessage');
        const cartBadge = document.getElementById('cartBadge');
        const mobileItemCount = document.getElementById('mobileItemCount');
        const subtotalEl = document.getElementById('subtotalAmount');
        const taxEl = document.getElementById('taxAmount');
        const totalEl = document.getElementById('totalAmount');
        const mobileTotalEl = document.getElementById('mobileTotal');
        const checkoutBtn = document.getElementById('checkoutBtn');
        const clearCartBtn = document.getElementById('clearCartBtn');
        
        const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));

        // --- Clock ---
        function updateClock() {
            const now = new Date();
            document.getElementById('clock-time').textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            document.getElementById('clock-date').textContent = now.toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric', year: 'numeric' });
        }
        setInterval(updateClock, 1000);
        updateClock();

        // --- Fetch Products ---
        async function fetchProducts() {
            if (isFetching) return;
            isFetching = true;
            
            productGrid.innerHTML = '';
            emptyState.classList.add('d-none');
            loadingState.classList.remove('d-none');

            try {
                // Determine query params
                const params = new URLSearchParams();
                if (currentCategoryId) params.append('category_id', currentCategoryId);
                if (currentSearch) params.append('search', currentSearch);
                
                // Assuming /kiosk/products returns { data: [...] } or array
                const response = await fetch('/kiosk/products?' + params.toString(), {
                    headers: { 'Accept': 'application/json' }
                });
                
                if (!response.ok) throw new Error('Failed to fetch products');
                
                const result = await response.json();
                const products = Array.isArray(result) ? result : (result.data || []);
                
                renderProducts(products);
            } catch (error) {
                console.error(error);
                productGrid.innerHTML = '<div class="col-12 text-center text-danger">Failed to load products. Please try again.</div>';
            } finally {
                loadingState.classList.add('d-none');
                isFetching = false;
            }
        }

        function formatCurrency(amount) {
            return '₱' + parseFloat(amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }

        function renderProducts(products) {
            if (products.length === 0) {
                emptyState.classList.remove('d-none');
                return;
            }

            const html = products.map(product => {
                const isOutOfStock = product.current_stock <= 0;
                const stockClass = isOutOfStock ? 'out-stock' : 'in-stock';
                const stockText = isOutOfStock ? 'Out of Stock' : 'In Stock';
                const imgSrc = product.image || null;

                let imageHtml = imgSrc 
                    ? '<img src="/storage/' + imgSrc + '" alt="' + product.name + '" loading="lazy">'
                    : '<i class="bi bi-box"></i>';

                return '<div class="product-card">' +
                    '<div class="stock-badge ' + stockClass + '">' + stockText + '</div>' +
                    '<div class="product-img-wrapper">' + imageHtml + '</div>' +
                    '<div class="product-name" title="' + product.name.replace(/"/g, '&quot;') + '">' + product.name + '</div>' +
                    '<div class="product-price">' + formatCurrency(product.unit_price) + '</div>' +
                    '<button class="btn-add-cart" ' +
                    'onclick="addToCart(' + product.id + ', \'' + product.name.replace(/'/g, "\\'") + '\', ' + product.unit_price + ', ' + isOutOfStock + ', \'' + (product.image ? product.image.replace(/'/g, "\\'") : '') + '\')"' +
                    (isOutOfStock ? ' disabled' : '') + '>' +
                    '<i class="bi bi-plus-circle me-1"></i> Add to Cart' +
                    '</button>' +
                    '</div>';
            }).join('');

            productGrid.innerHTML = html;
        }

        // --- Cart Logic ---
        function addToCart(id, name, price, isOutOfStock, image) {
            if (isOutOfStock) return;

            const existingItem = cart.find(item => item.id === id);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({ id, name, price, quantity: 1, image: image || '' });
            }
            renderCart();
            
            // On mobile, expand cart momentarily to show feedback
            if (window.innerWidth <= 768) {
                const cartSection = document.getElementById('cartSection');
                cartSection.classList.add('expanded');
                setTimeout(() => cartSection.classList.remove('expanded'), 1500);
            }
        }

        function updateQuantity(id, newQty) {
            if (newQty <= 0) {
                if (confirm('Remove item from cart?')) {
                    removeFromCart(id);
                }
                return;
            }
            const item = cart.find(item => item.id === id);
            if (item) {
                item.quantity = newQty;
                renderCart();
            }
        }

        function removeFromCart(id) {
            cart = cart.filter(item => item.id !== id);
            renderCart();
        }

        function clearCart() {
            if (confirm('Are you sure you want to clear the entire cart?')) {
                cart = [];
                renderCart();
            }
        }

        // Make functions globally available
        window.addToCart = addToCart;
        window.updateQuantity = updateQuantity;
        window.removeFromCart = removeFromCart;
        window.printReceipt = printReceipt;
        window.startNewTransaction = startNewTransaction;

        function renderCart() {
            // Calculate totals
            let subtotal = 0;
            let totalItems = 0;

            cart.forEach(item => {
                subtotal += item.price * item.quantity;
                totalItems += item.quantity;
            });

            const taxRate = {{ ($settings['default_tax_rate'] ?? 12) / 100 }};
            const tax = subtotal * taxRate;
            const total = subtotal + tax;

            // Update UI totals
            subtotalEl.textContent = formatCurrency(subtotal);
            taxEl.textContent = formatCurrency(tax);
            totalEl.textContent = formatCurrency(total);
            mobileTotalEl.textContent = formatCurrency(total);
            
            cartBadge.textContent = totalItems + ' item' + (totalItems !== 1 ? 's' : '');
            mobileItemCount.textContent = totalItems;

            // Update buttons
            if (cart.length > 0) {
                checkoutBtn.disabled = false;
                clearCartBtn.style.display = 'block';
                emptyCartMessage.style.display = 'none';
                
                // Render items
                const html = cart.map(item => {
                    return '<div class="cart-item">' +
                        '<button class="btn-remove" onclick="removeFromCart(' + item.id + ')" title="Remove">' +
                            '<i class="bi bi-x-circle-fill fs-5"></i>' +
                        '</button>' +
                        '<div class="cart-item-img">' +
                            (item.image ? '<img src="/storage/' + item.image + '" alt="' + item.name + '" style="width:100%;height:100%;object-fit:cover;border-radius:8px;">' : '<i class="bi bi-box fs-3 text-muted"></i>') +
                        '</div>' +
                        '<div class="cart-item-details">' +
                            '<div class="cart-item-title">' + item.name + '</div>' +
                            '<div class="cart-item-price">' + formatCurrency(item.price) + '</div>' +
                            '<div class="d-flex justify-content-between align-items-center">' +
                                '<div class="qty-controls">' +
                                    '<button class="qty-btn" onclick="updateQuantity(' + item.id + ', ' + (item.quantity - 1) + ')">' +
                                        '<i class="bi bi-dash"></i>' +
                                    '</button>' +
                                    '<input type="number" class="qty-input" value="' + item.quantity + '" readonly>' +
                                    '<button class="qty-btn" onclick="updateQuantity(' + item.id + ', ' + (item.quantity + 1) + ')">' +
                                        '<i class="bi bi-plus"></i>' +
                                    '</button>' +
                                '</div>' +
                                '<div class="fw-bold">' + formatCurrency(item.price * item.quantity) + '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
                }).join('');
                
                // Keep the empty message in DOM but hidden, insert HTML around it
                const itemsContainer = document.createElement('div');
                itemsContainer.innerHTML = html;
                
                // Clear existing items but keep empty message
                Array.from(cartItemsList.children).forEach(child => {
                    if (child.id !== 'emptyCartMessage') child.remove();
                });
                
                cartItemsList.insertBefore(itemsContainer, emptyCartMessage);
                
                // Flatten the container
                while (itemsContainer.firstChild) {
                    cartItemsList.insertBefore(itemsContainer.firstChild, itemsContainer);
                }
                itemsContainer.remove();

            } else {
                checkoutBtn.disabled = true;
                clearCartBtn.style.display = 'none';
                emptyCartMessage.style.display = 'block';
                
                // Remove all item elements
                Array.from(cartItemsList.children).forEach(child => {
                    if (child.id !== 'emptyCartMessage') child.remove();
                });
            }
        }

        // --- Checkout ---
        let pollingInterval = null;
        let waitingModal = null;

        document.addEventListener('DOMContentLoaded', function() {
            waitingModal = new bootstrap.Modal(document.getElementById('waitingModal'));
        });

        checkoutBtn.addEventListener('click', async () => {
            if (cart.length === 0) return;

            const originalBtnText = checkoutBtn.innerHTML;
            checkoutBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Processing...';
            checkoutBtn.disabled = true;

            try {
                const response = await fetch('/kiosk/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        items: cart.map(item => ({
                            product_id: item.id,
                            quantity: item.quantity
                        }))
                    })
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Checkout failed');
                }

                // Show waiting screen and start polling
                document.getElementById('pendingTxnNumber').textContent = '#' + (result.transaction_number || result.transaction_id);
                if (!waitingModal) waitingModal = new bootstrap.Modal(document.getElementById('waitingModal'));
                waitingModal.show();

                // Poll for transaction status every 2 seconds
                pollingInterval = setInterval(async () => {
                    try {
                        const statusResponse = await fetch('/kiosk/transaction/' + result.transaction_id + '/status');
                        const txn = await statusResponse.json();

                        document.getElementById('pendingTxnNumber').textContent = '#' + (txn.transaction_number || txn.id);

                        if (txn.status === 'completed') {
                            clearInterval(pollingInterval);
                            pollingInterval = null;
                            waitingModal.hide();
                            // Show the thank-you / completion screen instead of receipt modal directly
                            setTimeout(() => showCompletionScreen(txn), 400);
                        }
                    } catch (e) {
                        // Silent fail — keep polling
                    }
                }, 2000);

            } catch (error) {
                alert(error.message);
                checkoutBtn.innerHTML = originalBtnText;
                checkoutBtn.disabled = false;
            }
        });

        function generateLocalReceipt() {
            // Fallback if transaction details aren't returned perfectly
            let subtotal = 0;
            const items = cart.map(item => {
                const lineTotal = item.price * item.quantity;
                subtotal += lineTotal;
                return { name: item.name, price: item.price, quantity: item.quantity, subtotal: lineTotal };
            });
            const taxRate = {{ ($settings['default_tax_rate'] ?? 12) / 100 }};
            const tax = subtotal * taxRate;
            const total = subtotal + tax;
            
            return {
                transaction_number: 'TXN-' + Math.floor(Math.random() * 1000000),
                created_at: new Date().toISOString(),
                items: items,
                subtotal: subtotal,
                tax: tax,
                total: total
            };
        }

        function showReceipt(txn) {
            const receiptBody = document.getElementById('receiptContent');
            const taxRate = {{ ($settings['default_tax_rate'] ?? 12) / 100 }};
            const taxLabel = '{{ $settings["tax_name"] ?? "VAT" }} ({{ $settings["default_tax_rate"] ?? 12 }}%)';
            const storeName = '{{ $settings["store_name"] ?? "PureVibe" }}';
            const footerMsg = '{{ $settings["receipt_footer"] ?? "Thank you for shopping with us!" }}';

            let itemsHtml = (txn.items || cart).map(item => {
                return '<div class="receipt-item small">' +
                    '<div style="flex:2">' + item.quantity + 'x ' + item.name + '</div>' +
                    '<div style="flex:1; text-align:right">' + formatCurrency(item.price || (item.subtotal/item.quantity)) + '</div>' +
                    '<div style="flex:1; text-align:right">' + formatCurrency(item.subtotal || (item.price*item.quantity)) + '</div>' +
                '</div>';
            }).join('');

            const subtotal = txn.subtotal || 0;
            const tax = txn.tax_amount || txn.tax || (subtotal * taxRate);
            const total = txn.total_amount || txn.total || (subtotal + tax);

            receiptBody.innerHTML =
                '<div class="receipt-header">' +
                    '<h3 class="mb-1">' + storeName + '</h3>' +
                    '<div class="small text-muted">Self-Checkout Kiosk</div>' +
                    '<div class="small mt-2">Txn: ' + (txn.transaction_number || txn.reference_number || '—') + '</div>' +
                    '<div class="small">Date: ' + new Date(txn.created_at).toLocaleString() + '</div>' +
                '</div>' +
                '<div class="mb-3">' +
                    '<div class="receipt-item small fw-bold mb-2">' +
                        '<div style="flex:2">Item</div>' +
                        '<div style="flex:1; text-align:right">Price</div>' +
                        '<div style="flex:1; text-align:right">Total</div>' +
                    '</div>' +
                    itemsHtml +
                '</div>' +
                '<div class="receipt-total">' +
                    '<div class="d-flex justify-content-between mb-1 small">' +
                        '<span>Subtotal</span>' +
                        '<span>' + formatCurrency(subtotal) + '</span>' +
                    '</div>' +
                    '<div class="d-flex justify-content-between mb-1 small">' +
                        '<span>' + taxLabel + '</span>' +
                        '<span>' + formatCurrency(tax) + '</span>' +
                    '</div>' +
                    '<div class="d-flex justify-content-between fs-5 mt-2">' +
                        '<span>TOTAL</span>' +
                        '<span>' + formatCurrency(total) + '</span>' +
                    '</div>' +
                '</div>' +
                '<div class="text-center mt-4 small text-muted">' +
                    footerMsg +
                '</div>';

            receiptModal.show();
        }

        function printReceipt() {
            const printContent = document.getElementById('receiptContent').innerHTML;
            const originalContent = document.body.innerHTML;
            
            document.body.innerHTML = '<div style="max-width: 400px; margin: 0 auto; padding: 20px; font-family: monospace;">' + printContent + '</div>';
            window.print();
            document.body.innerHTML = originalContent;
            
            // Need to reload to get event listeners back
            window.location.reload();
        }

        function startNewTransaction() {
            // Stop any polling
            if (pollingInterval) {
                clearInterval(pollingInterval);
                pollingInterval = null;
            }
            cart = [];
            renderCart();
            receiptModal.hide();

            // Reset checkout button
            checkoutBtn.innerHTML = '<span>Checkout</span><i class="bi bi-arrow-right-circle-fill"></i>';
            checkoutBtn.disabled = true;

            // Refresh products to update stock
            fetchProducts();
        }

        // =============================================
        //  IDLE SCREEN LOGIC
        // =============================================
        function dismissIdleScreen() {
            document.getElementById('idleScreen').classList.add('hidden');
        }

        function showIdleScreen() {
            const idle = document.getElementById('idleScreen');
            idle.classList.remove('hidden');
        }

        // Sync idle clock with main clock
        function updateIdleClock() {
            const now = new Date();
            const idleTime = document.getElementById('idleClockTime');
            const idleDate = document.getElementById('idleClockDate');
            if (idleTime) idleTime.textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            if (idleDate) idleDate.textContent = now.toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric', year: 'numeric' });
        }
        setInterval(updateIdleClock, 1000);
        updateIdleClock();

        // =============================================
        //  COMPLETION / THANK YOU SCREEN LOGIC
        // =============================================
        const COMPLETION_TIMER_SECONDS = 30;
        let completionTimerInterval = null;
        let completionTimerRemaining = COMPLETION_TIMER_SECONDS;
        let completionTxnData = null;

        const RING_CIRCUMFERENCE = 364.425; // 2 * PI * 58

        function showCompletionScreen(txn) {
            completionTxnData = txn;

            // Populate mini receipt preview
            const taxRate = {{ ($settings['default_tax_rate'] ?? 12) / 100 }};
            const taxLabel = '{{ $settings["tax_name"] ?? "VAT" }} ({{ $settings["default_tax_rate"] ?? 12 }}%)';
            const storeName = '{{ $settings["store_name"] ?? "PureVibe" }}';
            const footerMsg = '{{ $settings["receipt_footer"] ?? "Thank you for shopping with us!" }}';

            const subtotal = txn.subtotal || 0;
            const tax = txn.tax_amount || txn.tax || (subtotal * taxRate);
            const total = txn.total_amount || txn.total || (subtotal + tax);

            let receiptLines = '';
            receiptLines += '<div style="text-align:center;border-bottom:1px dashed rgba(255,255,255,0.2);padding-bottom:0.75rem;margin-bottom:0.75rem;">';
            receiptLines += '<strong style="font-size:1rem;">' + storeName + '</strong><br>';
            receiptLines += '<span style="opacity:0.6;font-size:0.75rem;">Txn: ' + (txn.transaction_number || txn.reference_number || '—') + '</span><br>';
            receiptLines += '<span style="opacity:0.5;font-size:0.7rem;">' + new Date(txn.created_at || new Date()).toLocaleString() + '</span>';
            receiptLines += '</div>';

            (txn.items || cart).forEach(item => {
                const lineTotal = item.subtotal || (item.price * item.quantity);
                receiptLines += '<div style="display:flex;justify-content:space-between;margin-bottom:4px;">';
                receiptLines += '<span>' + item.quantity + 'x ' + item.name + '</span>';
                receiptLines += '<span>' + formatCurrency(lineTotal) + '</span>';
                receiptLines += '</div>';
            });

            receiptLines += '<div style="border-top:1px dashed rgba(255,255,255,0.2);margin-top:0.75rem;padding-top:0.75rem;">';
            receiptLines += '<div style="display:flex;justify-content:space-between;"><span>Subtotal</span><span>' + formatCurrency(subtotal) + '</span></div>';
            receiptLines += '<div style="display:flex;justify-content:space-between;"><span>' + taxLabel + '</span><span>' + formatCurrency(tax) + '</span></div>';
            receiptLines += '<div style="display:flex;justify-content:space-between;font-weight:bold;font-size:1.1rem;margin-top:6px;"><span>TOTAL</span><span>' + formatCurrency(total) + '</span></div>';
            receiptLines += '</div>';
            receiptLines += '<div style="text-align:center;margin-top:0.75rem;opacity:0.5;font-size:0.75rem;">' + footerMsg + '</div>';

            document.getElementById('completionReceiptText').innerHTML = receiptLines;

            // Reset and start timer
            completionTimerRemaining = COMPLETION_TIMER_SECONDS;
            document.getElementById('timerCount').textContent = completionTimerRemaining;
            document.getElementById('timerRingProgress').style.strokeDashoffset = '0';

            // Re-animate the check icon
            const checkEl = document.getElementById('completionCheck');
            checkEl.style.animation = 'none';
            checkEl.offsetHeight; // reflow
            checkEl.style.animation = '';

            // Show completion screen
            document.getElementById('completionScreen').classList.remove('hidden');

            // Start countdown
            clearInterval(completionTimerInterval);
            completionTimerInterval = setInterval(() => {
                completionTimerRemaining--;
                document.getElementById('timerCount').textContent = completionTimerRemaining;

                // Update ring: dashoffset goes from 0 → CIRCUMFERENCE
                const progress = completionTimerRemaining / COMPLETION_TIMER_SECONDS;
                const offset = RING_CIRCUMFERENCE * (1 - progress);
                document.getElementById('timerRingProgress').style.strokeDashoffset = offset;

                if (completionTimerRemaining <= 0) {
                    clearInterval(completionTimerInterval);
                    resetToIdle();
                }
            }, 1000);
        }

        function completionPrintReceipt() {
            if (!completionTxnData) return;
            // Populate the hidden receipt modal content for printing
            showReceipt(completionTxnData);
            // A brief delay so receipt modal content is populated, then trigger print silently
            setTimeout(() => {
                printReceipt();
            }, 200);
        }

        function resetToIdle() {
            // Stop timer
            clearInterval(completionTimerInterval);
            completionTimerInterval = null;

            // Hide completion screen
            document.getElementById('completionScreen').classList.add('hidden');

            // Reset cart and UI
            if (pollingInterval) {
                clearInterval(pollingInterval);
                pollingInterval = null;
            }
            cart = [];
            renderCart();
            receiptModal.hide();
            checkoutBtn.innerHTML = '<span>Checkout</span><i class="bi bi-arrow-right-circle-fill"></i>';
            checkoutBtn.disabled = true;
            fetchProducts();

            // Show idle screen
            showIdleScreen();
        }

        // --- Event Listeners ---

        // Category Filter
        catPills.forEach(pill => {
            pill.addEventListener('click', (e) => {
                catPills.forEach(p => p.classList.remove('active'));
                e.target.classList.add('active');
                currentCategoryId = e.target.dataset.id;
                fetchProducts();
            });
        });

        // Search Input (Debounced)
        let searchTimeout;
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                currentSearch = e.target.value.trim();
                fetchProducts();
            }, 300);
        });

        // Mobile Cart Toggle
        document.getElementById('mobileCartToggle').addEventListener('click', () => {
            document.getElementById('cartSection').classList.toggle('expanded');
        });

        clearCartBtn.addEventListener('click', clearCart);

        // =============================================
        //  INACTIVITY TIMEOUT
        // =============================================
        const INACTIVITY_TIMEOUT_MS = 60000; // 60 seconds
        let inactivityTimer = null;

        function isBlockingScreenActive() {
            // Don't trigger idle if admin confirmation or completion screen is up
            const completionVisible = !document.getElementById('completionScreen').classList.contains('hidden');
            const waitingVisible   = document.getElementById('waitingModal').classList.contains('show');
            const receiptVisible   = document.getElementById('receiptModal').classList.contains('show');
            const idleVisible      = !document.getElementById('idleScreen').classList.contains('hidden');
            return completionVisible || waitingVisible || receiptVisible || idleVisible;
        }

        function updateIdleScreenForCart() {
            const ctaText    = document.getElementById('idleCtaText');
            const ctaIcon    = document.getElementById('idleCtaIcon');
            const subtitle   = document.getElementById('idleSubtitle');
            const cartBadge  = document.getElementById('idleCartBadge');
            const cartCount  = document.getElementById('idleCartCount');

            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);

            if (totalItems > 0) {
                // Resuming an in-progress order
                subtitle.textContent  = 'Your session is paused.';
                ctaIcon.className     = 'bi bi-play-circle';
                ctaText.textContent   = 'Tap anywhere to continue your order';
                cartBadge.style.display = 'block';
                cartCount.textContent = totalItems + ' item' + (totalItems !== 1 ? 's' : '') + ' in your cart';
            } else {
                // Fresh welcome screen
                subtitle.textContent  = 'Self-Checkout Kiosk — Fast & Easy';
                ctaIcon.className     = 'bi bi-hand-index-thumb';
                ctaText.textContent   = 'Tap anywhere to start your order';
                cartBadge.style.display = 'none';
            }
        }

        function triggerIdleFromInactivity() {
            if (isBlockingScreenActive()) return;
            updateIdleScreenForCart();
            showIdleScreen();
        }

        function resetInactivityTimer() {
            clearTimeout(inactivityTimer);
            // Only run the timer when the idle screen is NOT already showing
            if (!isBlockingScreenActive()) {
                inactivityTimer = setTimeout(triggerIdleFromInactivity, INACTIVITY_TIMEOUT_MS);
            }
        }

        // Listen for any user activity to reset the timer
        const ACTIVITY_EVENTS = ['mousemove', 'mousedown', 'touchstart', 'touchmove', 'keydown', 'scroll', 'click'];
        ACTIVITY_EVENTS.forEach(evt => {
            document.addEventListener(evt, resetInactivityTimer, { passive: true });
        });

        // Override dismissIdleScreen to also restart the inactivity timer
        const _originalDismissIdleScreen = dismissIdleScreen;
        dismissIdleScreen = function() {
            _originalDismissIdleScreen();
            resetInactivityTimer();
        };

        // Kick off timer on page load (after products load, the idle screen covers it anyway initially)
        // Start counting as soon as user dismisses the initial idle screen
        resetInactivityTimer();

        // --- Initialize ---
        fetchProducts();

    </script>
</body>
</html>
