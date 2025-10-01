@extends('backend.layouts.app')
@section('content')
    <style>
        #main-layout {
            margin-bottom: 40px;
            display: flex;
            justify-content: center;
        }

        #buttonGroup {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            margin-left: 40%;
        }

        .moved-left {
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }

        #analyticsContainer {
            display: flex;
            flex-direction: column;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s ease, visibility 0s 0.5s;
            width: 70%;
        }

        #analyticsContainer.visible {
            visibility: visible;
            opacity: 1;
            transition: opacity 0.5s ease;
        }

        .analytics-section {
            display: none;
        }

        .analytics-section.d-block {
            display: block;
        }

        .form-check {
            margin-bottom: 10px;
        }

        .checkboxes-save-container {
            display: flex;
            align-items: center;
        }

        .save-btn {
            margin-left: -400px;
        }

        #header {
            margin: 30px;
            margin-bottom: 50px;

        }
    </style>

    <!-- ============================================================== -->
    <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="mb-4 mb-sm-0 card-title">Analytics</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a class="text-muted text-decoration-none d-flex" href="{{ route('home') }}">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div id="header">
        <h4>Please select the analytics you would like to view:</h4>
    </div>

    <div id="main-layout">
        <!-- Buttons Container (Vertically stacked in the center) -->
        <div id="buttonGroup">
            <button id="btn-daily" class="btn btn-dark" onclick="toggleSection('daily', this)" style="width: 200%">Daily
                analytics</button>
            <button id="btn-weekly" class="btn btn-dark" onclick="toggleSection('weekly', this)" style="width: 200%">Weekly
                analytics</button>
            <button id="btn-monthly" class="btn btn-dark" onclick="toggleSection('monthly', this)"
                style="width: 200%">Monthly analytics</button>
        </div>

        <!-- Analytics Sections (Right side, hidden initially) -->
        <div id="analyticsContainer">
            <!-- Daily Analytics -->
            <div id="daily" class="analytics-section">
                <h5>Daily Analytics</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="performance_agent_confirmation" id="daily1"
                        data-section="daily" checked>
                    <label class="form-check-label" for="daily1">Performance Agent Confirmation</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="performance_last_mile" id="daily2"
                        data-section="daily">
                    <label class="form-check-label" for="daily2">Performance Last Mile</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="performance_delivery_man" id="daily3"
                        data-section="daily">
                    <label class="form-check-label" for="daily3">Performance Delivery Man</label>
                </div>
            </div>

            <!-- Weekly Analytics -->
            <div id="weekly" class="analytics-section">
                <h5>Weekly Analytics</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="performance_agent_confirmation" id="weekly1"
                        data-section="weekly">
                    <label class="form-check-label" for="weekly1">Performance Agent Confirmation</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="performance_last_mile" id="weekly2"
                        data-section="weekly">
                    <label class="form-check-label" for="weekly2">Performance Last Mile</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="performance_delivery_man" id="weekly3"
                        data-section="weekly">
                    <label class="form-check-label" for="weekly3">Performance Delivery Man</label>
                </div>
            </div>

            <!-- Monthly Analytics -->
            <div id="monthly" class="analytics-section">
                <h5>Monthly Analytics</h5>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="performance_agent_confirmation" id="monthly1"
                        data-section="monthly">
                    <label class="form-check-label" for="monthly1">Performance Agent Confirmation</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="performance_last_mile" id="monthly2"
                        data-section="monthly">
                    <label class="form-check-label" for="monthly2">Performance Last Mile</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="performance_delivery_man" id="monthly3"
                        data-section="monthly">
                    <label class="form-check-label" for="monthly3">Performance Delivery Man</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="total_spend_expenses" id="monthly4"
                        data-section="monthly">
                    <label class="form-check-label" for="monthly4">Total Spend Expenses</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="calculate_roi" id="monthly5"
                        data-section="monthly">
                    <label class="form-check-label" for="monthly5">Calculate ROI</label>
                </div>
            </div>
        </div>

        <div class="checkboxes-save-container">
            <button type="button" class="btn btn-outline-dark save-btn" onclick="saveSelections()">Save</button>
        </div>
    </div>
@endsection

<script>
    const clickedSections = new Set();
    const preferences = @json($preferences);

    document.addEventListener("DOMContentLoaded", () => {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');

        checkboxes.forEach((checkbox) => {
            const section = checkbox.getAttribute('data-section');
            const value = checkbox.value;

            if (
                (section === 'daily' && preferences.daily?.includes(value)) ||
                (section === 'weekly' && preferences.weekly?.includes(value)) ||
                (section === 'monthly' && preferences.monthly?.includes(value))
            ) {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }
        });
    });

    function toggleSection(sectionId, clickedBtn) {
        const buttonGroup = document.getElementById('buttonGroup');
        const analyticsContainer = document.getElementById('analyticsContainer');

        buttonGroup.classList.add('moved-left');

        analyticsContainer.classList.add('visible');

        document.querySelectorAll('.analytics-section').forEach(sec => sec.classList.remove('d-block'));
        document.getElementById(sectionId).classList.add('d-block');

        document.querySelectorAll('.btn-dark').forEach(btn => btn.disabled = false);
        clickedBtn.disabled = true;

        clickedSections.add(sectionId);
    }

    function saveSelections() {
        const result = {};

        clickedSections.forEach(section => {
            const checkboxes = document.querySelectorAll(`input[type="checkbox"][data-section="${section}"]`);
            const checked = [];

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    checked.push(checkbox.value);
                }
            });

            if (checked.length > 0) {
                result[section] = checked;
            }
        });

        fetch("{{ route('save-whatsapp-preferences') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(result)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success('Preferences saved successfully!', 'Success', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                    // setTimeout(function() {
                    //     location.reload();
                    // }, 2000);
                }
            })
            .catch(error => {
                toastr.error(errorMessage, 'Error saving preferences', {
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp",
                    timeOut: 2000
                });
            });

    }
</script>
