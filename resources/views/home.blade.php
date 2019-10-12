<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>League</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="{{asset('css/stylesheet.css')}}">
        <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col text-center"><button id="reset">Reset League</button></div>
            </div>
            <div class="row">
                <div class="col-9">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="table-title">League Table</h5>
                            <table id="leagueTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Teams</th>
                                        <th>PTS</th>
                                        <th>P</th>
                                        <th>W</th>
                                        <th>D</th>
                                        <th>L</th>
                                        <th>GD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teams as $team)
                                        <tr>
                                            <td>
                                                {{$team->name}}<br>
                                            </td>
                                            <td>{{$team->points}}</td>
                                            <td>{{$team->played}}</td>
                                            <td>{{$team->won}}</td>
                                            <td>{{$team->drawn}}</td>
                                            <td>{{$team->lost}}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-left">
                                            <button id="playAll">Play All</button>
                                        </td>
                                        <td colspan="4" class="text-right">
                                            <button id="nextWeekBtn">Next Week</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-4">
                            <h5 class="table-title">Match Results</h5>
                            <table id="resultsTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Home Team</th>
                                        <th>Score</th>
                                        <th>Visitor Team</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($thisWeekMatches as $match)
                                        <tr>
                                            <td>
                                                {{$match->homeTeam->name}}
                                            </td>
                                            <td>{{(int)$match->home_goals}} - {{(int)$match->visitor_goals}}</td>
                                            <td>{{$match->visitorTeam->name}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <h5>Week <span id="weekSpan"></span> Predictions of Championship</h5>
                    <div class="col">
                        <table class="table table-striped" id="champPercTable">
                            <tbody>
                                @foreach($teams as $team)
                                    <tr>
                                        <td>{{$team->name}}- {{$team->champPercantage}}</td>
                                        <td>percentage</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <h5 class="table-title">Fixtures</h5>
                    <table class="table table-striped" id="fixturesTable">
                        <thead>
                            <tr>
                                <th>Week</th>
                                <th>Home</th>
                                <th>Visitor</th>
                                <th>Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fixtures as $fixture)
                                <tr>
                                    <td>
                                        {{$fixture->week}}
                                    </td>
                                    <td>
                                        {{$fixture->homeTeam->name}}
                                    </td>
                                    <td>
                                        {{$fixture->visitorTeam->name}}
                                    </td>
                                    <td>
                                        @if($fixture->played)
                                            {{ $fixture->home_goals }} - {{ $fixture->visitor_goals }}
                                        @else
                                            Not played yet
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="ajax-loader">
            <div class="loader-inside"><img src="{{asset('ajax-loader.gif')}}"></div>
        </div>

        <script>
            $(document).ajaxStart(function(){
                $(".ajax-loader").show();
            });

            $(document).ajaxStop(function(){
                $(".ajax-loader").hide();
            });

            $(document).ready(function(){
                function loadFixtures(){
                    $.ajax({
                        url: '{{route("loadfixtures")}}'
                    }).done(function(data){
                        $('#fixturesTable').children('tbody').remove();
                        $('#fixturesTable').append('<tbody></tbody>');

                        var tbody = $('#fixturesTable').children('tbody');

                        $.each(data, function(key, value){
                            tbody.append('<tr>' +
                                    '<td>'+ value.week +'</td>' +
                                    '<td>'+ value.home_team.name +'</td>' +
                                    '<td>'+ value.visitor_team.name +'</td>' +
                                    '<td>'+ (value.played ? (value.home_goals +' - '+ value.visitor_goals) : 'Not played yet') +'</td>' +
                                '</tr>'
                            );
                        });
                    });
                }

                function loadLeagueTable(){
                    $.ajax({
                        url: '{{route("loadleaguetable")}}'
                    }).done(function(data){
                        var tbody = $('#leagueTable').children('tbody')

                        tbody.children('tr').remove();

                        $.each(data, function(key, value){
                            tbody.append('<tr>' +
                                    '<td>'+ value.name +'</td>' +
                                    '<td>'+ value.points +'</td>' +
                                    '<td>'+ value.played +'</td>' +
                                    '<td>'+ value.won +'</td>' +
                                    '<td>'+ value.drawn +'</td>' +
                                    '<td>'+ value.lost +'</td>' +
                                    '<td>'+ value.goalDifference +'</td>' +
                                '</tr>'
                            );
                        });

                    });
                }

                function loadPercentages(){
                    $.ajax({
                        url: '{{route("getchampperc")}}'
                    }).done(function(data){
                        $("#weekSpan").text(data.week.week);

                        var tbody = $('#champPercTable').children('tbody')

                        tbody.children('tr').remove();

                        $.each(data.percentages, function(key, value){
                            tbody.append('<tr><td>'+ value.team.name +'</td><td>'+ value.perc +'%</td></tr>');
                        });

                    });
                }

                $("#nextWeekBtn").on('click', function(){
                    $.ajax({
                        'url': '{{ route("makematch") }}'
                    }).done(function(data){
                        //var tbody = $('#resultsTable').children('tbody');
                        //tbody.children('tr').remove();
                        $('#resultsTable').children('tbody').remove();

                        $('#resultsTable').append('<tbody></tbody>');
                        var tbody = $('#resultsTable').children('tbody');

                        $.each(data, function(key, value){
                            tbody.append('<tr><td>'+ value.home.team +'</td><td>'+ value.home.goals +' - '+ value.visitor.goals +'</td><td>'+ value.visitor.team +'</td></tr>');
                        });
                        loadPercentages();
                        loadLeagueTable();
                        loadFixtures();
                    });
                });

                $("#playAll").on('click', function(){
                    $.ajax({
                        'url': '{{ route("playall") }}'
                    }).done(function(data){
                        $('#resultsTable').children('tbody').remove();

                        $('#resultsTable').append('<tbody></tbody>');
                        var tbody = $('#resultsTable').children('tbody');

                        $.each(data, function(key, value){
                            tbody.append('<tr><td>'+ value.home.team +'</td><td>'+ value.home.goals +' - '+ value.visitor.goals +'</td><td>'+ value.visitor.team +'</td></tr>');
                        });
                        loadPercentages();
                        loadLeagueTable();
                        loadFixtures();
                    });
                });

                $('#reset').on('click', function(){
                    $.ajax({
                        'url': '{{ route("resetleague") }}'
                    }).done(function(data){
                        location.reload(true);
                    });
                });

                loadPercentages();
                loadLeagueTable();
                loadFixtures();
            });

        </script>
    </body>
</html>
