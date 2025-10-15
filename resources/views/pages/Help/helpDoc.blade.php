@extends('layouts.app')

{{-- @ DESCRIPTION      => help --}}
{{-- @ ENDPOINT         => HelpController.php --}}
{{-- @ ACCESS           => all members in space section --}}
{{-- @ CREATED BY       => Redesgined by Diuth Induwara, Harindu Ashen --}}
{{-- @ CREATED DATE     => 2024/06/26 --}}

@section('title')
    Help
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('/css/help.css') }}">
@endpush

@section('content')
<div class="row" style="min-height: 80vh;">
    <div class="col-sm-5">
        <div class="sidebar" id="mySidebar">
            <div class="scroll-container">
                <ul class="menu">
                    <li class="li">
                        <a href="#" data-key="home">Home</a>
                    </li>
                    <li class="li">
                        <a href="#" data-key="initial_data">Initial Data <span class="arrow"></span></a>
                        <ul class="submenu">
                            <li class="li"><a href="#" data-key="initial_new_event">Initial New Event</a></li>
                            <li class="li"><a href="#" data-key="initial_events">Initial Events</a></li>
                            <li class="li"><a href="#" data-key="employees">Employees</a></li>
                            <li class="li"><a href="#" data-key="tasks">Tasks</a></li>
                        </ul>
                    </li>
                    <li class="li">
                        <a href="#" data-key="process_data">Process Data <span class="arrow"></span></a>
                        <ul class="submenu">
                            <li class="li"><a href="#" data-key="manage_events">Manage Events</a></li>
                            <li class="li"><a href="#" data-key="assigned_employees">Assigned Employees</a></li>
                            <li class="li"><a href="#" data-key="register_students">Register Students</a></li>
                        </ul>
                    </li>
                    <li class="li">
                        <a href="#" data-key="documentation">Documentation <span class="arrow"></span></a>
                        <ul class="submenu">
                            <li class="li"><a href="#" data-key="invitation">Invitation</a></li>
                            <li class="li"><a href="#" data-key="certification">Certification</a></li>
                        </ul>
                    </li>
                    <li class="li">
                        <a href="#" data-key="help">Help</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-sm-7">
        <div class="content" id="content">
            <!-- Content related to the selected option will be loaded here -->
            <p>Select a menu item to load content.</p>
        </div>
    </div>
    
</div>

<script>
    const contentData = {
        'home': '<h2 style="padding-left:70vh;color:#100c5e; font-family:Times New Roman, Times, serif;">Home</h2><p >Welcome to the help section. Use the sidebar to navigate..Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32..</p>',
        'initial_data': '<h2 style="padding-left: 70vh;color:#100c5e; font-family:Times New Roman, Times, serif;">Initial Data</h2><p style="margin-left:0px;">Here you will find information on setting up initial data.</p>',
        'initial_new_event': '<h2 style="padding-left: 70vh;color:#100c5e; font-family:Times New Roman, Times, serif;">Initial New Event</h2><p style="padding-left: 20px;">Guide on creating a new event.</p>',
        'initial_events': '<h2 style="padding-left: 70vh;color:#100c5e; font-family:Times New Roman, Times, serif;">Initial Events</h2><p style="padding-left: 20px;">View and manage initial events here.</p>',
        'employees': '<h2 style="padding-left: 70vh;color:#100c5e; font-family:Times New Roman, Times, serif;">Employees</h2><p style="padding-left: 20px;">Information on managing employees.</p>',
        'tasks': '<h2 style="padding-left: 70vh;color:#100c5e; font-family:Times New Roman, Times, serif;">Tasks</h2><p style="padding-left: 20px;">Task management guide.</p>',
        'process_data': '<h2 style="padding-left: 70vh;color:#100c5e; font-family:Times New Roman, Times, serif;">Process Data</h2><p style="padding-left: 20px;">Instructions for processing data.</p>',
        'manage_events': '<h2 style="padding-left: 70vh;color:#100c5e; font-family:Times New Roman, Times, serif;">Manage Events</h2><p style="padding-left: 20px;">Event management guide.</p>',
        'assigned_employees': '<h2 style="padding-left: 70vh;color:#100c5e; font-family:Times New Roman, Times, serif;">Assigned Employees</h2><p style="padding-left: 20px;">Guide on managing assigned employees.</p>',
        'register_students': '<h2 style="padding-left: 70vh;color:#100c5e; font-family:Times New Roman, Times, serif;">Register Students</h2><p style="padding-left: 20px;">Guide on registering students.</p>',
        'documentation': '<h2 style="padding-left: 70vh;color:#100c5e; font-family:Times New Roman, Times, serif;">Documentation</h2><p style="padding-left: 20px;">Official documentation resources.</p>',
        'invitation': '<h2 style="padding-left: 70vh;color:#100c5e; font-family:Times New Roman, Times, serif;">Invitation</h2><p style="padding-left: 20px;">Invitation templates and examples.</p>',
        'certification': '<h2 style="padding-left:70vh;color:#100c5e; font-family:Times New Roman, Times, serif;" >Certification</h2><p style="padding-left: 20px;">Certification management and templates.</p>',
        'help':'<h1 style="padding-left: 70vh;color:#100c5e; font-family:Times New Roman, Times, serif;">Help</h1><p style="padding-left: 20px;">How to get help and support.</p>'
    };

    function openInRightFrame(event, contentKey) {
        event.preventDefault();
        const content = contentData[contentKey];
        document.getElementById('content').innerHTML = content ? content : '<p>Content not available.</p>';
    }

    // Attach event listeners to the menu items
    document.querySelectorAll('.menu > li > a, .submenu > li > a').forEach(function(anchor) {
        anchor.addEventListener('click', function(event) {
            const contentKey = this.getAttribute('data-key');
            openInRightFrame(event, contentKey);
        });
    });

    // Expand/collapse submenu functionality
    document.querySelectorAll('.menu > li > a').forEach(function(anchor) {
        anchor.addEventListener('click', function(event) {
            var submenu = this.nextElementSibling;
            var arrow = this.querySelector('.arrow');
            if (submenu && submenu.style.display === 'block') {
                submenu.style.display = 'none';
                arrow.classList.remove('down');
            } else if (submenu) {
                submenu.style.display = 'block';
                arrow.classList.add('down');
            }
            event.preventDefault();
        });
    });
</script>
@endsection
