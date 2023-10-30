@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-8">
            <canvas id="perfisMaisVisualizados"></canvas>
        </div>

        <div class="col-12 col-md-4">
            <canvas id="tagsMaisUltPostsDoughnut"></canvas>
        </div>
        
        <div class="col-12 col-md-4">
            <canvas id="tagsMaisUltUsersDoughnut"></canvas>
        </div>    
        
        <div class="col-12 col-md-8">
            <canvas id="perfisPostsCurtidos"></canvas>
        </div>    
        
        <div class="col-12 col-md-12">     
            <canvas id="crecimentoQuantidadeUsuarios"></canvas>
        </div> 
    </div>
</div>
<style>
    .user_visu{
        background: #eceef1;
        border-radius: 20px;
        padding: 20px 0px;
        margin-bottom: 15px;
    }
    .user_visu h2{
        text-align: center;
        margin-bottom: 15px;
    }
    .user_visu span{
        float: right;
        padding: 1px 10px;
        border-radius: 12px;
        background: #1f2d3d;
        color: white;
    }
    .user_visu a, .user_visu .user_visu_interno{
        text-decoration: none;
        width: 100%;
        display: block;
        padding: 10px 10px;
    }
    .user_visu a:hover, .user_visu .user_visu_interno:hover{
        background: #b6b0b0;
        border-radius: 5px;
    }
    .user_visu a h4, .user_visu .user_visu_interno h4{
        color: #212529;
        margin-bottom: 0;
    }
    .user_visu a.user_visu_a_ultimo{
        background: #1f2d3dcc;
        text-align: center;
        border-radius: 0px 0px 12px 12px;
    }
    .user_visu a.user_visu_a_ultimo:hover{
        background: #1f2d3d;
    }
    .user_visu a.user_visu_a_ultimo h4{
        color: #eceef1;
    }
</style>
@endsection
@section('javascript')

<script>
    var data1 = "{{ $quantidadeMesAntes[0]->datas }}";
    data1 = data1.split(" ")[0].split('-').reverse().join('/');
    
    var data2 = "{{ $quantidadeMesAnterior[0]->datasAnterior }}";
    data2 = data2.split(" ")[0].split('-').reverse().join('/');

    var data3 = "{{ $quantidadeMes[0]->datas }}";
    data3 = data3.split(" ")[0].split('-').reverse().join('/');

    var backgroundColor = [
        'rgba(255, 193, 7, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(50, 168, 82, 0.2)',
        'rgba(168, 50, 50, 0.2)',
        'rgba(168, 107, 50, 0.2)',
        'rgba(167, 201, 44, 0.2)',
        'rgba(117, 201, 44, 0.2)',
        'rgba(44, 201, 109, 0.2)',
        'rgba(44, 201, 177, 0.2)',
        'rgba(44, 109, 201, 0.2)',
    ];
    var borderColor = [
        'rgba(255, 193, 7, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(50, 168, 82, 1)',
        'rgba(168, 50, 50, 1)',
        'rgba(168, 107, 50, 1)',
        'rgba(167, 201, 44, 1)',
        'rgba(117, 201, 44, 1)',
        'rgba(44, 201, 109, 1)',
        'rgba(44, 201, 177, 1)',
        'rgba(44, 109, 201, 1)',
    ];
    var queciUser = document.getElementById('crecimentoQuantidadeUsuarios').getContext('2d');
    var crecimentoQuantidadeUsuarios = new Chart(queciUser, {
        type: 'line',
        data: {
            labels: [data1, data2, data3],
            datasets: [{
                label: 'Crecimento',
                data: ['{{ $quantidadeMesAntes[0]->crecimento }}', '{{ $quantidadeMesAnterior[0]->crecimento }}', '{{ $quantidadeMes[0]->crecimento }}'],
                backgroundColor: backgroundColor,
                borderColor: borderColor,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Percentual de crecimento dos ultimos 3 meses'
                },
            },
            interaction: {
                intersect: false,
            },
            scales: {
                x: {
                    display: true,
                    title: {
                    display: true
                }
            },
            y: {
                display: true,
                title: {
                    display: true,
                    text: 'Quantidade de usuarios'
                },
                suggestedMin: 0,
                suggestedMax: @if($quantidadeMesAntes[0]->crecimento > $quantidadeMesAnterior[0]->crecimento && $quantidadeMesAntes[0]->crecimento > $quantidadeMes[0]->crecimento) '{{$quantidadeMesAntes[0]->crecimento}}' @elseif($quantidadeMesAnterior[0]->crecimento > $quantidadeMesAntes[0]->crecimento && $quantidadeMesAnterior[0]->crecimento > $quantidadeMes[0]->crecimento) '{{$quantidadeMesAnterior[0]->crecimento}}' @else '{{$quantidadeMes[0]->crecimento}}' @endif ,
            }
        }
    }
    });


    var perfisVisu = document.getElementById('perfisMaisVisualizados').getContext('2d');
    var perfisMaisVisualizados = new Chart(perfisVisu, {
        type: 'line',
        data: {
            labels: [
                @foreach($numero_visualizacao as $user)
                    '{{$user->name}}',
                @endforeach
            ],
            datasets: [{
                label: 'Crecimento',
                data: [
                    @foreach($numero_visualizacao as $user)
                        {{$user->numero_visualizacao}},
                    @endforeach
                ],
                backgroundColor: backgroundColor,
                borderColor: borderColor,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Perfis mais visualizados'
                },
            },
            interaction: {
                intersect: false,
            },
            scales: {
                x: {
                    display: true,
                    title: {
                    display: true
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Quantidade de usuarios'
                    },
                    min: 0,
                    max: {{$numero_visualizacao[0]->numero_visualizacao + 10}},
                }
            }
        }
    });

    var tagsMaisUltPostsDoughnut = document.getElementById("tagsMaisUltPostsDoughnut");
    var tagsMaisUltPostsDoughnut2 = new Chart(tagsMaisUltPostsDoughnut, {
    type: 'pie',
    data: {
        labels: [ 
                @foreach($tagPost as $tp)
                    '{{$tp->tag}}',
                @endforeach
            ],
        datasets: [{
            label: '# of Tomatoes',
            data: [
                @foreach($tagPost as $tp)
                    {{$tp->numBerLikesTP}},
                @endforeach
            ],
            backgroundColor: backgroundColor,
            borderColor: borderColor,
            borderWidth: 1
        }]
    },
    options: {
        //cutoutPercentage: 40,
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Tags mais utilizadas por posts'
            }, 
            legend: {
                display: false
            }
        }

    }
    });
    var tagsMaisUltUsersDoughnut = document.getElementById("tagsMaisUltUsersDoughnut");
    var tagsMaisUltUsersDoughnut2 = new Chart(tagsMaisUltUsersDoughnut, {
    type: 'pie',
    data: {
        labels: [ 
                @foreach($tagUser as $tu)
                    '{{$tu->tag}}',
                @endforeach
            ],
        datasets: [{
            label: "TeamA Score",
            data: [
                @foreach($tagUser as $tu)
                    {{$tu->numBerLikesTU}},
                @endforeach
            ],
            backgroundColor: backgroundColor,
            borderColor: borderColor,
            borderWidth: 1
        }]
    },
    options: {
        //cutoutPercentage: 40,
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Tags mais utilizadas por usuarios'
            }, 
            legend: {
                display: false
            }
        },
        

    }
    });

    var perfisPosts = document.getElementById('perfisPostsCurtidos').getContext('2d');
    var perfisPostsCurtidos = new Chart(perfisPosts, {
        type: 'bar',
        data: {
            labels: [
                @foreach($usersPostLike as $tu)
                    '{{$tu->name}}',
                @endforeach
            ],
            datasets: [{
                label: 'Crecimento',
                data: [
                    @foreach($usersPostLike as $tu)
                        {{$tu->numBerLikes}},
                    @endforeach
                ],
                backgroundColor: backgroundColor,
                borderColor: borderColor,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Perfis com mais posts curtidos',
                },
            },
            interaction: {
                intersect: false,
            },
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true
                    }
            },
            y: {
                display: true,
                title: {
                    display: true,
                    text: 'Quantidade de usuarios',
                },
                suggestedMin: 0,
                suggestedMax: {{$usersPostLike[0]->numBerLikes + 10}},
            }
        }
    }
    });
</script>
 
@endsection