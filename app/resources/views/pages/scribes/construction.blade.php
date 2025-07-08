@extends('layouts.topnav')

@section('content')
    @include('partials.scribes.nav')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('scribes.construction.title') }}</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <p>{{ __('scribes.construction.p1') }}</p>
                    <p>{{ __('scribes.construction.p2') }}</p>
                    <em>
                        <p>{!! __('scribes.construction.more_info') !!}</p>
                    </em>
                </div>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Buildings</h3>
        </div>
        <div class="box-body table-responsive">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped" style="margin-bottom: 0">
                        <colgroup>
                            <col>
                            <col>
                            <col>
                        </colgroup>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Land</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buildingTypeWithLandType as $buildingType => $landType)
                                <tr>
                                    <td>
                                        {{ $buildingHelper->getBuildingName($buildingType) }}
                                    </td>
                                    <td>
                                        @if ($landType !== NULL)
                                            {!! $landHelper->getLandTypeIconHtml($landType) !!} {{ ucfirst($landType) }}
                                        @else
                                            Race dependant
                                        @endif
                                    </td>
                                    <td>
                                        {!! $buildingHelper->getBuildingHelpString($buildingType)  !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
