@extends('filament::layouts.base')

@section('head')
    @parent
    <style>
        /* تخصيص ألوان Filament Admin Panel */
        
        /* الألوان الأساسية */
        :root {
            --primary: #ea580c;
            --primary-50: #fff7ed;
            --primary-100: #ffedd5;
            --primary-200: #fed7aa;
            --primary-300: #fdba74;
            --primary-400: #fb923c;
            --primary-500: #f97316;
            --primary-600: #ea580c;
            --primary-700: #c2410c;
            --primary-800: #9a3412;
            --primary-900: #7c2d12;
        }

        /* تخصيص الأزرار */
        .filament-button-primary,
        .btn-primary,
        [class*="bg-primary"] {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%) !important;
            border: none !important;
            box-shadow: 0 4px 6px -1px rgba(249, 115, 22, 0.3) !important;
            transition: all 0.3s ease !important;
        }

        .filament-button-primary:hover,
        .btn-primary:hover,
        [class*="bg-primary"]:hover {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 8px -1px rgba(249, 115, 22, 0.4) !important;
        }

        /* تخصيص الروابط */
        .filament-link,
        [class*="text-primary"] {
            color: #ea580c !important;
            transition: color 0.2s ease !important;
        }

        .filament-link:hover,
        [class*="text-primary"]:hover {
            color: #c2410c !important;
        }

        /* تخصيص الـ Navigation */
        .filament-sidebar-nav-item.active,
        .filament-sidebar-nav-item[aria-current="page"] {
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%) !important;
            border-left: 4px solid #ea580c !important;
        }

        .filament-sidebar-nav-item.active .filament-sidebar-nav-item-icon,
        .filament-sidebar-nav-item.active .filament-sidebar-nav-item-label,
        .filament-sidebar-nav-item[aria-current="page"] .filament-sidebar-nav-item-icon,
        .filament-sidebar-nav-item[aria-current="page"] .filament-sidebar-nav-item-label {
            color: #ea580c !important;
        }

        /* تخصيص الـ Header */
        .filament-header {
            background: linear-gradient(135deg, #ffffff 0%, #fff7ed 100%) !important;
            border-bottom: 1px solid #fed7aa !important;
        }

        /* تخصيص الـ Cards */
        .filament-card {
            border: 1px solid #fed7aa !important;
            box-shadow: 0 1px 3px 0 rgba(249, 115, 22, 0.1) !important;
            transition: all 0.3s ease !important;
        }

        .filament-card:hover {
            box-shadow: 0 4px 6px -1px rgba(249, 115, 22, 0.2) !important;
            transform: translateY(-1px) !important;
        }

        /* تخصيص الـ Forms */
        .filament-form-field input:focus,
        .filament-form-field select:focus,
        .filament-form-field textarea:focus,
        input:focus,
        select:focus,
        textarea:focus {
            border-color: #ea580c !important;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1) !important;
        }

        /* تخصيص الـ Tables */
        .filament-table-header {
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%) !important;
            border-bottom: 2px solid #ea580c !important;
        }

        .filament-table-row:hover {
            background: #fff7ed !important;
        }

        /* تخصيص الـ Badges */
        .filament-badge-primary,
        .badge-primary {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%) !important;
            color: white !important;
            box-shadow: 0 2px 4px rgba(249, 115, 22, 0.3) !important;
        }

        /* تخصيص الـ Login Page */
        .filament-login-card {
            background: linear-gradient(135deg, #ffffff 0%, #fff7ed 100%) !important;
            border: 1px solid #fed7aa !important;
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.15) !important;
        }

        /* تخصيص الـ Sidebar */
        .filament-sidebar {
            background: linear-gradient(180deg, #ffffff 0%, #fff7ed 100%) !important;
            border-right: 1px solid #fed7aa !important;
        }

        .filament-sidebar-brand {
            border-bottom: 1px solid #fed7aa !important;
        }

        /* تخصيص ألوان Tailwind */
        .bg-primary-600 {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%) !important;
        }

        .bg-primary-500 {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%) !important;
        }

        .text-primary-600 {
            color: #ea580c !important;
        }

        .border-primary-600 {
            border-color: #ea580c !important;
        }

        .focus\:border-primary-600:focus {
            border-color: #ea580c !important;
        }

        .focus\:ring-primary-600:focus {
            --tw-ring-color: rgba(249, 115, 22, 0.3) !important;
        }

        /* تخصيص أزرار التحكم */
        button[type="submit"],
        .btn-primary,
        .filament-button--color-primary {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%) !important;
            border: none !important;
            box-shadow: 0 4px 6px -1px rgba(249, 115, 22, 0.3) !important;
            transition: all 0.3s ease !important;
        }

        button[type="submit"]:hover,
        .btn-primary:hover,
        .filament-button--color-primary:hover {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 8px -1px rgba(249, 115, 22, 0.4) !important;
        }

        /* تخصيص الـ Checkboxes */
        input[type="checkbox"]:checked {
            background-color: #ea580c !important;
            border-color: #ea580c !important;
        }

        /* تخصيص الـ Radio Buttons */
        input[type="radio"]:checked {
            background-color: #ea580c !important;
            border-color: #ea580c !important;
        }

        /* تخصيص الـ Select Dropdowns */
        select:focus {
            border-color: #ea580c !important;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1) !important;
        }

        /* تخصيص الـ Toggle Switches */
        .toggle-switch:checked {
            background-color: #ea580c !important;
        }

        /* تخصيص الـ Progress Bars */
        .progress-bar {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%) !important;
        }

        /* تخصيص الـ Tabs */
        .filament-tabs-item.active,
        .tab-active {
            border-bottom-color: #ea580c !important;
            color: #ea580c !important;
        }

        /* تخصيص الـ Notifications */
        .filament-notification--success {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%) !important;
        }

        .filament-notification--error {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;
        }

        .filament-notification--warning {
            background: linear-gradient(135deg, #eab308 0%, #d97706 100%) !important;
        }
    </style>
@endsection 