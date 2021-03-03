@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }} 
                    <a href="{{ route('customer.extract.detail', ['company_id' => Auth::user()->company()->first()->id ,'customer_id' => session()->get('customer_id') ]) }}">
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
                <div class="card-header">Resgatar Pontos </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('point.rescue') }}">
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
                                <label for="points" class="col-md-4 col-form-label text-md-right">{{ __('Quantidade de pontos a ser resgatado') }}</label>
    
                                <div class="col-md-6">
                                    <input id="points" type="number" min="1" class="form-control price-price @error('points') is-invalid @enderror" name="points" value="{{ old('points') }}" autocomplete="off" required>
    
                                    @error('points')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Resgatar') }}
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
    });
</script>
@stop
