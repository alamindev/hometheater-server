@extends('layouts.app')
@section('title')
Service view
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>View Service</h4>
                    <a href="{{ url()->previous() }}" class="btn btn-success"> <i class="fa  fa-arrow-left "></i>
                        Back</a>
                </div>
                <div class="card-body card-block">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Service title</td>
                                <td>:</td>
                                <td>{{ $view->title }}</td>
                            </tr>
                            <tr>
                                <td>Price</td>
                                <td>:</td>
                                <td>${{ $view->basic_price }}</td>
                            </tr>
                            <tr>
                                <td>Service Icon</td>
                                <td>:</td>
                                <td>${{ $view->icon }}</td>
                            </tr>
                            <tr>
                                <td>Service Category</td>
                                <td>:</td>
                                <td>{{ $view->category->cate_name }}</td>
                            </tr>
                            <tr>
                                <td>Service details</td>
                                <td>:</td>
                                <td>{!! $view->details !!}</td>
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
            <div class="card">
                <div class="card-header">
                    <h4>Service Question</h4>
                </div>
                <div class="card-body card-block">
                    <div class="row">
                        @foreach($view->serviceQuestion as $data)
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Question: </strong> {{$data->name}}
                                </div>
                                <div class="card-body">
                                    <div class="list-group">
                                        @php
                                        $options = \App\Models\QuestionOption::where('question_id', $data->id)->get();
                                        @endphp
                                        @foreach($options as $option)
                                        <div class="list-group-item">
                                            <strong>Option:</strong> {{ $option->title }} <br>
                                            <strong>Price:</strong> ${{$option->price}}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
