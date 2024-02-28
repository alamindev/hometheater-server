@extends('layouts.app')
@section('title')
Product view
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>View Product</h4>
                    <a href="{{ route('products') }}" class="btn btn-success"> <i class="fa  fa-arrow-left "></i>
                        Back</a>
                </div>
                <div class="card-body card-block">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Product title</td>
                                <td>:</td>
                                <td>{{ $view->title }}</td>
                            </tr>
                            <tr>
                                <td>Price</td>
                                <td>:</td>
                                <td>${{ $view->basic_price }}</td>
                            </tr> 
                            <tr>
                                <td>Product Category</td>
                                <td>:</td>
                                <td>{{ $view->category->cate_name }}</td>
                            </tr>
                            <tr>
                                <td>Product details</td>
                                <td>:</td>
                                <td>{!! $view->details !!}</td>
                            </tr>
                            <tr>
                                <td>Seo details</td>
                                <td>:</td>
                                <td>{!! $view->seo_details !!}</td>
                            </tr>
                            <tr>
                                <td>Keyword</td>
                                <td>:</td>
                                <td>{!! $view->keyword !!}</td>
                            </tr>
                            <tr>
                                <td>Suggestion</td>
                                <td>:</td>
                                @php
                                $suggestion_id = explode(',', $view->suggestion)
                                @endphp
                                <td>
                                    @foreach (App\Models\Service::whereIn('id', $suggestion_id)->get() as
                                    $service) <p class="font-weight-bold">{{ $service->title }},</p> <br>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td>Thumbnail</td>
                                <td>:</td>
                                <td>
                                 <img class="pt-2 " width="100" src="{{ asset('storage'. $view->thumbnail )}}" alt="service-thumbnail">
                                </td>
                            </tr>
                            <tr>
                                <td><b style="color: red">Delivery Time</b></td>
                                <td>:</td>
                                <td>
                                  <strong class="display-5"> {{ $view->delivery_time }} Days</strong> 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Service Images</h4>
                </div>
                <div class="card-body card-block">
                    <div class="row">
                        @foreach($view->serviceImage as $image)
                        <div class="col-lg-4">
                            <img src="{{ asset('storage'. $image->image )}}" alt="service-image">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Service Feature</h4>
                </div>
                <div class="card-body card-block">
                    <table class="table table-bordered">
                        <tbody>
                            @php
                            $features = explode('||#||', $view->datas);
                            array_pop($features);
                            @endphp
                            @foreach($features as $feature)
                            <tr>
                                <td>{{ $feature }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
