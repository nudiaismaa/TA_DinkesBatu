@extends('layout.index')
@section('title', 'Puskesmas Page')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @include('puskesmas.puskesmas.create')
                @include('puskesmas.akun_puskesmas.create')
                <x-card class="h-100">
                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="puskesmas-tab" data-bs-toggle="tab"
                                data-bs-target="#puskesmas-tab-pane" type="button" role="tab"
                                aria-controls="puskesmas-tab-pane" aria-selected="true">Puskesmas</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="akun-puskesmas-tab" data-bs-toggle="tab"
                                data-bs-target="#akun-puskesmas-tab-pane" type="button" role="tab"
                                aria-controls="akun-puskesmas-tab-pane" aria-selected="false">Akun Puskesmas</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        @include('puskesmas.puskesmas.index')
                        @include('puskesmas.akun_puskesmas.index')
                    </div>
                </x-card>
                @if (session('success'))
                    <x-toast status='success' title='Berhasil!'>
                        {{ session('success') }}
                    </x-toast>
                @endif
                @if (session('error'))
                    <x-toast status='error' title='Gagal!'>
                        {{ session('error') }}
                    </x-toast>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Check if there's an active tab session variable
            const activeTab = "{{ session('active_tab') }}";
            if (activeTab) {
                // Remove active class from all tabs
                document.querySelectorAll('#myTab .nav-link').forEach(tab => {
                    tab.classList.remove('active');
                });

                // Add active class to the specified tab
                const activeTabElement = document.getElementById(activeTab);
                if (activeTabElement) {
                    activeTabElement.classList.add('active');
                }

                // Remove active class from all tab panes
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.classList.remove('show', 'active');
                });

                // Add active class to the specified tab pane
                const activeTabPane = document.querySelector(activeTabElement.getAttribute('data-bs-target'));
                if (activeTabPane) {
                    activeTabPane.classList.add('show', 'active');
                }
            }
        });
    </script>
@endsection
