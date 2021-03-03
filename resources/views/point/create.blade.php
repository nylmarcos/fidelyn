@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }} 
                    <a href="{{ route('customer.extract.detail', ['company_id' => $company->id,'customer_id' => session()->get('customer_id') ]) }}">
                        Visualizar Extrato
                    </a>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif
            @if(session()->has('warning'))
                <div class="alert alert-warning">
                    {{ session()->get('warning') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">Lançar Pontos - {{ $company->name }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('point.store') }}">
                            @csrf
                            
                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Telefone') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="off" autofocus>

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Valor da Compra') }}</label>

                                <div class="col-md-6">
                                    <input id="price" type="text" 
                                        class="form-control @error('price') is-invalid @enderror" 
                                        name="price" value="{{ old('price') }}" 
                                        data-affixes-stay="true" data-prefix="R$ "
                                        required autocomplete="off"  
                                        data-thousands="." data-decimal="," />

                                    @error('price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row"> 
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Pontos') }}</label>
                                <div class="col-md-6">
                                    <div class="alert alert-warning" id="pontos-calculado">
                                        0
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row"> 
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Lembrete') }}</label>
                                <div class="col-md-6" id="explicacao">
                                    A cada R$ {{ $company->price }}  em compra seu cliente ganhará {{ $company->points }} ponto(s). 
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Lançar') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function($) {
        $('#price').maskMoney();
        $("#phone").mask("(99) 99999-9999");
        $("#phone").focus();

        $('#price').keyup(delay(function (e) {
            $.post( "/point/calculate", { price: this.value } , function(data) {
                if (data.pontos == 50) {
                    data.pontos = data.pontos + " pontos é o máximo permitido";
                } 
                $('#pontos-calculado').text(data.pontos);
            });
        }, 500));
    });
    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
            callback.apply(context, args);
            }, ms || 0);
        };
    }
</script>
@stop
