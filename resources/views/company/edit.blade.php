@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }} 
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Seu Negócio') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('company.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome da Empresa') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $company->name }}" required autocomplete="off" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Telefone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $company->phone }}" autocomplete="off" required>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('Qual valor da compra para seu cliente pontuar?') }}</label>

                            <div class="col-md-6">
                                <input id="price" type="number" class="form-control price-price @error('price') is-invalid @enderror" name="price" value="{{ $company->price }}" autocomplete="off" required>

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="points" class="col-md-4 col-form-label text-md-right">{{ __('Quanto pontos seu cliente ganhará?') }}</label>

                            <div class="col-md-6">
                                <input id="points" type="number" class="form-control price-price @error('points') is-invalid @enderror" name="points" value="{{ $company->points }}" autocomplete="off" required>

                                @error('points')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="months_point_expiration" class="col-md-4 col-form-label text-md-right">{{ __('Validade do ponto? (em meses)') }}</label>

                            <div class="col-md-6">
                                <input id="months_point_expiration" type="number" class="form-control price-price @error('months_point_expiration') is-invalid @enderror" name="months_point_expiration" value="{{ $company->months_point_expiration }}" autocomplete="off" required>

                                @error('months_point_expiration')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="information" class="col-md-4 col-form-label text-md-right">{{ __('Informação') }}</label>

                            <div class="col-md-6">
                                <textarea id="information" name="information" rows="3" 
                                cols="44" class="form-control">{{ $company->information }}</textarea>
                                @error('information')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row"> 
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Entenda') }}</label>
                            <div class="col-md-6" id="explicacao">
                                A cada R$ X  em compra seu cliente ganhará X ponto(s). 
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Atualizar') }}
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
        $("#phone").mask("(99) 99999-9999");
        $( ".price-price" ).keyup(function() {
            var price = $('#price').val();
            var points = $('#points').val();

            $('#explicacao').text("A cada R$ "+price+" em compra seu cliente ganhará "+points+" ponto(s). ");
        });
    });
</script>
@stop
