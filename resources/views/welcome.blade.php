@extends('layout.app')
        <link href="{{ asset('fullCalendar/fullcalendar/dist/fullcalendar.css') }}" rel="stylesheet">
@section('content')


<style>
    .panel-default{
        background: rgba(255,254,240,0.3);
        border: 0px;

    }

    hr {
        display: block;
        height: 1px;
        border: 0;
        border-top: 1px solid rgba(255,254,240,0.3);
        margin: 1em 0;
        padding: 0; 
    }
    .well{
        background: rgba(34,34,34,0.2);
        border: 1px solid rgba(245,245,245,0.2);
   
    }
</style>
<div class="row">

    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading" style="background: rgba(255,254,240,0.5);border: 0px"><a><strong><i class="fa fa-bolt"></i> Acceso rapido</strong></a></div>
            <div class="panel-body">
                <!--<a href="#"><strong><i class="glyphicon glyphicon-comment"></i> Acceso rapido</strong></a>-->

                <!--<hr>-->

                <small>Proceso 1</small>
                <div class="progress">
                    <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100" style="width: 72%">
                        <span class="sr-only">72% Complete</span>
                    </div>
                </div>
                <small>Proceso 2</small>
                <div class="progress">
                    <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                        <span class="sr-only">20% Complete</span>
                    </div>
                </div>
                <small>Proceso 3</small>
                <div class="progress">
                    <div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                        <span class="sr-only">60% Complete (warning)</span>
                    </div>
                </div>
                <small>Proceso 4</small>
                <div class="progress">
                    <div class="progress-bar progress-bar-danger progress-bar-striped active" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                        <span class="sr-only">80% Complete</span>
                    </div>
                </div>
                <small>Proceso 5</small>
                <div class="progress">
                    <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                        <span class="sr-only">50% Complete</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="panel panel-default">
            <div class="panel-heading" style="background: rgba(245,245,245,0.5);border: 0px"><a><strong><i class="fa fa-bell"></i> Mensajes</strong></a></div>
            <!--<div class="panel-body">-->
                <ul class="list-group">
                    <li class="list-group-item"><a href="#"><i class="fa fa-bell-o"></i> <small>(3 mins ago)</small> Alta de proveedor <strong>LABORATORIO, S.A DE C.V.</strong></a></li>
                    <li class="list-group-item"><a href="#"><i class="fa fa-bell-o"></i> <small>(1 hour ago)</small> Nuevo usuario</a></li>
                    <li class="list-group-item"><a href="#"><i class="fa fa-bell-o"></i> <small>(2 hrs ago)</small> Nuevo medicamento</a></li>
                    <li class="list-group-item"><a href="#"><i class="fa fa-bell-o"></i> <small>(4 hrs ago)</small> Nuevo Producto</a></li>
                    <li class="list-group-item"><a href="#"><i class="fa fa-bell-o"></i> <small>(yesterday)</small> Alta de proveedor <strong>CENTRAL, S.A. DE C.V.</strong>.</a></li>
                    <li class="list-group-item"><a href="#"><i class="fa fa-bell-o"></i> <small>(yesterday)</small> Alta de proveedor <strong>LABORATORIO, S.A DE C.V.</strong></a></li>
                </ul>
            <!--</div>-->
        </div>
        
    </div>

    <div class="col-md-1"></div>
    <div class="col-md-6">
       
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script type="text/javascript" src="{{ asset('js/nmn_cat_empleados.js') }}"></script>

        <script src="{{ asset('fullCalendar/moment/moment.js')}}"></script>
        <script src="{{ asset('fullCalendar/fullcalendar/dist/fullcalendar.js')}}"></script>
        <script src="{{ asset('fullCalendar/fullcalendar/dist/locale/es.js')}}"></script>
       <script>
$(document).ready(function () {

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        eventClick: function (event, element) {

            $('#calendar').fullCalendar('removeEvents', event._id)


        },

        events: [
            {
                title: 'Event1',
                start: '2017-04-12',
                resourceEditable: true // resource not editable for this event
            },
            {
                title: 'Event2',
                start: '2017-04-12',
                end: '2017-04-12',
                resourceEditable: false // resource not editable for this event
            }
            // etc...
        ],

//        defaultDate: '2017-04-12',
//        navLinks: true, // can click day/week names to navigate views
        selectable: true,

        select: function (start, end) {
            var title = prompt('Event Title:');
            var eventData;
            if (title) {
                eventData = {
                    title: title,
                    start: start,
                    end: end
                };

                $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
            }
            $('#calendar').fullCalendar('unselect');


        },
        locale: 'es',

        eventColor: 'rgb(255,107,107)',
        editable: true,
        eventLimit: true, // allow "more" link when too many events


    });




});
        </script>
@stop