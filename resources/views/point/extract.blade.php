@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">{{ isset($company) ? $company->name.' - ' : null  }} Extrato {{ $phone_format }}</div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="GET" action="{{ route('customer.extract', ['company_id' => isset($company) ? $company->id : null ]) }}">
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Telefone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="" required autocomplete="off" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Extrato') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        @if($extrato)
                            <div class="col-md-12 mt-5">                            
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                        <th scope="col">Empresa</th>
                                        <th scope="col">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($extrato as $company)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('customer.extract.detail', ['company_id' => $company['company_id'], 'customer_id' => $company['customer_id'] ]) }}">
                                                        {{ $company['company_name'] }}</td>
                                                    </a>
                                                <td>{{ $company['balance'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
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
