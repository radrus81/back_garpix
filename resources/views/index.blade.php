@extends('layouts.app')
@section('content')
<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">               
    <div class="container">
        <div class="card card_block">
            <div class="card-header">                    
                Список товаров
            </div>
            <div class="alertMess alert" role="alert" style="display: none;"></div>                            
            <div class="card-body">
                <button type="button" class="btn btn-primary sortname" onclick="sortProducts('name');">
                    <span class="spinner-border spinner-border-sm spinnername"  role="status" aria-hidden="false" style="display: none;"></span>
                    <span class="textBtn">Отсортировать по названию (возрастанию)</span>
                </button>
                <button type="button" class="btn btn-secondary sortamount" onclick="sortProducts('amount');">
                    <span class="spinner-border spinner-border-sm spinneramount" role="status" style="display: none;"></span>                                                   
                    <span class="textBtn">Отсортировать по цене (возрастанию)</span>
                </button>
                @include('table')
            </div>
        </div>           
    </div>
</div>
@endsection
