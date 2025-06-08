@extends('layout.index')
@section('title', 'Posyandu Page')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @include('posyandu.posyandu.create')
                @if (!auth()->user()->hasRole('Puskesmas'))
                    @include('posyandu.akun_posyandu.create')
                @endif
                <x-card class="h-100">
                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="posyandu-tab" data-bs-toggle="tab"
                                data-bs-target="#posyandu-tab-pane" type="button" role="tab"
                                aria-controls="posyandu-tab-pane" aria-selected="true">Posyandu</button>
                        </li>
                        @if (!auth()->user()->hasRole('Puskesmas'))
                            <li class="nav-item">
                                <button class="nav-link" id="akun-posyandu-tab" data-bs-toggle="tab"
                                    data-bs-target="#akun-posyandu-tab-pane" type="button" role="tab"
                                    aria-controls="akun-posyandu-tab-pane" aria-selected="false">Akun Posyandu</button>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        @include('posyandu.posyandu.index')
                        @role('Front Office')
                            @include('posyandu.akun_posyandu.index')
                        @endrole
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
