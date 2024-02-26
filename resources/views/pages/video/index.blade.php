@extends('layouts.app')
@section('style')
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"> 
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('Videos') }}</h4> 

                        </div>
                        <div class="card-body">
                            <div class="row"> 
                            </div>
                            <div class="table-responsive">
                                <table id="datatables" class="table table-striped table-bordered nowrap">
                                    <thead class="text-primary">
                                    <th>
                                        {{ __('#') }}
                                    </th>
                                    <th>
                                        {{ __('File name') }}
                                    </th>
                                    <th>
                                        {{ __('Title') }}
                                    </th>
                                 
                                    <th>
                                        {{ __('Status') }}
                                    </th>
                                    <th>
                                        {{ __('Creation') }}
                                    </th>
                                    <th class="text-right">
                                        {{ __('Actions') }}
                                    </th>
                                    </thead>
                                    <tbody> 

                                        <tr data-video="http://techslides.com/demos/sample-videos/small.mp4">
                                            <td>
                                            22
                                            </td>
                                            <td>
                                                <video autoplay loop class="embed-responsive-item w-100" >
                                                    <!--replace this sample with your video-->
                                                    <source src="http://techslides.com/demos/sample-videos/small.mp4" type="video/mp4">
                                                </video>
                                                 
                                            </td>
                                            <td>
                                             asdf
                                            </td>
                                            <td>
                                               asdf
                                            </td>
                                            <td>
                                             asdf
                                            </td>
                                            <td>
                                             asdf
                                            </td>
                                            
                                        </tr>
 
                                    </tbody>

                                    {{--dd("stoped")--}}

                                </table>
                                <div class="modal fade" id="myModal" role="dialog">
                                    <div class="modal-dialog modal-md">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">User Details</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="video"><p> </p><span></span></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> 
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#datatables').DataTable();
            $('#datatables tbody').on('click', 'tr', function () { 
                $(".modal-body div span").text("");
                let videourl = $(this).attr('data-video');
                let div = ` <video autoplay loop class="embed-responsive-item w-100" > 
                                <source src="${videourl}" type="video/mp4">
                            </video>`;
                $(".video span").html(div);
                $("#myModal").modal("show");
            });
        } );
    </script>
    <script>
        $(document).ready(function() {
            $('#datatables').fadeIn(1100);
            $('#datatables').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search videos",
                },
                "columnDefs": [
                    { "orderable": false, "targets": 5 },
                ],
            });
        });
    </script>
     
@endpush