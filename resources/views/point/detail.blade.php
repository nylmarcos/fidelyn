@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">Extrato - {{ $company->name }} </div>
                <div class="card-body">
                    <div class="alert alert-info" role="alert">
                        {{ $company->information }}
                        <br>
                        A cada R$ {{ $company->price }} em compras você ganhará {{ $company->points}} ponto(s).
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-5">                            
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                      <th scope="col">Vence em</th>
                                      <th scope="col">Ponto(s)</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($points as $point)
                                        <tr>
                                            <td>{{ $point->validity->diffInDays(\Carbon\Carbon::now()) }} dia(s)</td>
                                            <td>{{ $point->pontos }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="row">Total</th>
                                        <td>{{ $total->pontos }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function($) {
        $('#valor').maskMoney();
        $("#phone").mask("(99) 99999-9999");
        $("#phone").focus();
    });
</script>
@stop
