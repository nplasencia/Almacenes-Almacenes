@extends('layouts.email')
@section('content')

    @foreach($nextToExpireCentersAndItems as $center=>$articles)
        · Centro <span style="font-weight: bold;">{{ ucwords($center) }}</span>
        <table id="table" class="table table-hover table-mc-light-blue">
            <thead>
            <tr>
                <th>Artículo</th>
                <th>Almacén</th>
                <th>Ubicación</th>
                <th>Posición</th>
                <th>Caducidad</th>
            </tr>
            </thead>
            <tbody>
            @foreach($articles as $article)
                <tr>
                    <td>{{ $article->name }}</td>
                    <td>{{ $article->storeName }}</td>
                    <td>{{ $article->location }}</td>
                    <td>{{ $article->position }}</td>
                    <td>{{ $article->expiration }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach

@stop
@push('styles')
.table {
width: 100%;
max-width: 100%;
margin-bottom: 2rem;
background-color: #ffffff;
}
.table > thead > tr,
.table > tbody > tr,
.table > tfoot > tr {
-webkit-transition: all 0.3s ease;
transition: all 0.3s ease;
}
.table > thead > tr > th,
.table > tbody > tr > th,
.table > tfoot > tr > th,
.table > thead > tr > td,
.table > tbody > tr > td,
.table > tfoot > tr > td {
text-align: left;
padding: 1.6rem;
vertical-align: top;
border-top: 0;
-webkit-transition: all 0.3s ease;
transition: all 0.3s ease;
}
.table > thead > tr > th {
font-weight: 400;
color: #757575;
vertical-align: bottom;
border-bottom: 1px solid rgba(0, 0, 0, 0.12);
}
.table > caption + thead > tr:first-child > th,
.table > colgroup + thead > tr:first-child > th,
.table > thead:first-child > tr:first-child > th,
.table > caption + thead > tr:first-child > td,
.table > colgroup + thead > tr:first-child > td,
.table > thead:first-child > tr:first-child > td {
border-top: 0;
}
.table > tbody + tbody {
border-top: 1px solid rgba(0, 0, 0, 0.12);
}
.table .table {
background-color: #ffffff;
}
.table .no-border {
border: 0;
}
.table-condensed > thead > tr > th,
.table-condensed > tbody > tr > th,
.table-condensed > tfoot > tr > th,
.table-condensed > thead > tr > td,
.table-condensed > tbody > tr > td,
.table-condensed > tfoot > tr > td {
padding: 0.8rem;
}
.table-bordered {
border: 0;
}
.table-bordered > thead > tr > th,
.table-bordered > tbody > tr > th,
.table-bordered > tfoot > tr > th,
.table-bordered > thead > tr > td,
.table-bordered > tbody > tr > td,
.table-bordered > tfoot > tr > td {
border: 0;
border-bottom: 1px solid #e0e0e0;
}
.table-bordered > thead > tr > th,
.table-bordered > thead > tr > td {
border-bottom-width: 2px;
}
.table-striped > tbody > tr:nth-child(odd) > td,
.table-striped > tbody > tr:nth-child(odd) > th {
background-color: #f5f5f5;
}
.table-hover > tbody > tr:hover > td,
.table-hover > tbody > tr:hover > th {
background-color: rgba(0, 0, 0, 0.12);
}
@media screen and (max-width: 768px) {
.table-responsive-vertical > .table {
margin-bottom: 0;
background-color: transparent;
}
.table-responsive-vertical > .table > thead,
.table-responsive-vertical > .table > tfoot {
display: none;
}
.table-responsive-vertical > .table > tbody {
display: block;
}
.table-responsive-vertical > .table > tbody > tr {
display: block;
border: 1px solid #e0e0e0;
border-radius: 2px;
margin-bottom: 1.6rem;
}
.table-responsive-vertical > .table > tbody > tr > td {
background-color: #ffffff;
display: block;
vertical-align: middle;
text-align: right;
}
.table-responsive-vertical > .table > tbody > tr > td[data-title]:before {
content: attr(data-title);
float: left;
font-size: inherit;
font-weight: 400;
color: #757575;
}
.table-responsive-vertical.shadow-z-1 {
box-shadow: none;
}
.table-responsive-vertical.shadow-z-1 > .table > tbody > tr {
border: none;
box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.12), 0 1px 2px 0 rgba(0, 0, 0, 0.24);
}
.table-responsive-vertical > .table-bordered {
border: 0;
}
.table-responsive-vertical > .table-bordered > tbody > tr > td {
border: 0;
border-bottom: 1px solid #e0e0e0;
}
.table-responsive-vertical > .table-bordered > tbody > tr > td:last-child {
border-bottom: 0;
}
.table-responsive-vertical > .table-striped > tbody > tr > td,
.table-responsive-vertical > .table-striped > tbody > tr:nth-child(odd) {
background-color: #ffffff;
}
.table-responsive-vertical > .table-striped > tbody > tr > td:nth-child(odd) {
background-color: #f5f5f5;
}
.table-responsive-vertical > .table-hover > tbody > tr:hover > td,
.table-responsive-vertical > .table-hover > tbody > tr:hover {
background-color: #ffffff;
}
.table-responsive-vertical > .table-hover > tbody > tr > td:hover {
background-color: rgba(0, 0, 0, 0.12);
}
}
.table-striped.table-mc-red > tbody > tr:nth-child(odd) > td,
.table-striped.table-mc-red > tbody > tr:nth-child(odd) > th {
background-color: #fde0dc;
}
.table-hover.table-mc-red > tbody > tr:hover > td,
.table-hover.table-mc-red > tbody > tr:hover > th {
background-color: #f9bdbb;
}
@media screen and (max-width: 767px) {
.table-responsive-vertical .table-striped.table-mc-red > tbody > tr > td,
.table-responsive-vertical .table-striped.table-mc-red > tbody > tr:nth-child(odd) {
background-color: #ffffff;
}
.table-responsive-vertical .table-striped.table-mc-red > tbody > tr > td:nth-child(odd) {
background-color: #fde0dc;
}
.table-responsive-vertical .table-hover.table-mc-red > tbody > tr:hover > td,
.table-responsive-vertical .table-hover.table-mc-red > tbody > tr:hover {
background-color: #ffffff;
}
.table-responsive-vertical .table-hover.table-mc-red > tbody > tr > td:hover {
background-color: #f9bdbb;
}
}
.table-striped.table-mc-pink > tbody > tr:nth-child(odd) > td,
.table-striped.table-mc-pink > tbody > tr:nth-child(odd) > th {
background-color: #fce4ec;
}
.table-hover.table-mc-pink > tbody > tr:hover > td,
.table-hover.table-mc-pink > tbody > tr:hover > th {
background-color: #f8bbd0;
}
@media screen and (max-width: 767px) {
.table-responsive-vertical .table-striped.table-mc-pink > tbody > tr > td,
.table-responsive-vertical .table-striped.table-mc-pink > tbody > tr:nth-child(odd) {
background-color: #ffffff;
}
.table-responsive-vertical .table-striped.table-mc-pink > tbody > tr > td:nth-child(odd) {
background-color: #fce4ec;
}
.table-responsive-vertical .table-hover.table-mc-pink > tbody > tr:hover > td,
.table-responsive-vertical .table-hover.table-mc-pink > tbody > tr:hover {
background-color: #ffffff;
}
.table-responsive-vertical .table-hover.table-mc-pink > tbody > tr > td:hover {
background-color: #f8bbd0;
}
}
.table-striped.table-mc-purple > tbody > tr:nth-child(odd) > td,
.table-striped.table-mc-purple > tbody > tr:nth-child(odd) > th {
background-color: #f3e5f5;
}
.table-hover.table-mc-purple > tbody > tr:hover > td,
.table-hover.table-mc-purple > tbody > tr:hover > th {
background-color: #e1bee7;
}
@media screen and (max-width: 767px) {
.table-responsive-vertical .table-striped.table-mc-purple > tbody > tr > td,
.table-responsive-vertical .table-striped.table-mc-purple > tbody > tr:nth-child(odd) {
background-color: #ffffff;
}
.table-responsive-vertical .table-striped.table-mc-purple > tbody > tr > td:nth-child(odd) {
background-color: #f3e5f5;
}
.table-responsive-vertical .table-hover.table-mc-purple > tbody > tr:hover > td,
.table-responsive-vertical .table-hover.table-mc-purple > tbody > tr:hover {
background-color: #ffffff;
}
.table-responsive-vertical .table-hover.table-mc-purple > tbody > tr > td:hover {
background-color: #e1bee7;
}
}
.table-striped.table-mc-deep-purple > tbody > tr:nth-child(odd) > td,
.table-striped.table-mc-deep-purple > tbody > tr:nth-child(odd) > th {
background-color: #ede7f6;
}
.table-hover.table-mc-deep-purple > tbody > tr:hover > td,
.table-hover.table-mc-deep-purple > tbody > tr:hover > th {
background-color: #d1c4e9;
}
@media screen and (max-width: 767px) {
.table-responsive-vertical .table-striped.table-mc-deep-purple > tbody > tr > td,
.table-responsive-vertical .table-striped.table-mc-deep-purple > tbody > tr:nth-child(odd) {
background-color: #ffffff;
}
.table-responsive-vertical .table-striped.table-mc-deep-purple > tbody > tr > td:nth-child(odd) {
background-color: #ede7f6;
}
.table-responsive-vertical .table-hover.table-mc-deep-purple > tbody > tr:hover > td,
.table-responsive-vertical .table-hover.table-mc-deep-purple > tbody > tr:hover {
background-color: #ffffff;
}
.table-responsive-vertical .table-hover.table-mc-deep-purple > tbody > tr > td:hover {
background-color: #d1c4e9;
}
}
.table-striped.table-mc-indigo > tbody > tr:nth-child(odd) > td,
.table-striped.table-mc-indigo > tbody > tr:nth-child(odd) > th {
background-color: #e8eaf6;
}
.table-hover.table-mc-indigo > tbody > tr:hover > td,
.table-hover.table-mc-indigo > tbody > tr:hover > th {
background-color: #c5cae9;
}
@media screen and (max-width: 767px) {
.table-responsive-vertical .table-striped.table-mc-indigo > tbody > tr > td,
.table-responsive-vertical .table-striped.table-mc-indigo > tbody > tr:nth-child(odd) {
background-color: #ffffff;
}
.table-responsive-vertical .table-striped.table-mc-indigo > tbody > tr > td:nth-child(odd) {
background-color: #e8eaf6;
}
.table-responsive-vertical .table-hover.table-mc-indigo > tbody > tr:hover > td,
.table-responsive-vertical .table-hover.table-mc-indigo > tbody > tr:hover {
background-color: #ffffff;
}
.table-responsive-vertical .table-hover.table-mc-indigo > tbody > tr > td:hover {
background-color: #c5cae9;
}
}
.table-striped.table-mc-blue > tbody > tr:nth-child(odd) > td,
.table-striped.table-mc-blue > tbody > tr:nth-child(odd) > th {
background-color: #e7e9fd;
}
.table-hover.table-mc-blue > tbody > tr:hover > td,
.table-hover.table-mc-blue > tbody > tr:hover > th {
background-color: #d0d9ff;
}
@media screen and (max-width: 767px) {
.table-responsive-vertical .table-striped.table-mc-blue > tbody > tr > td,
.table-responsive-vertical .table-striped.table-mc-blue > tbody > tr:nth-child(odd) {
background-color: #ffffff;
}
.table-responsive-vertical .table-striped.table-mc-blue > tbody > tr > td:nth-child(odd) {
background-color: #e7e9fd;
}
.table-responsive-vertical .table-hover.table-mc-blue > tbody > tr:hover > td,
.table-responsive-vertical .table-hover.table-mc-blue > tbody > tr:hover {
background-color: #ffffff;
}
.table-responsive-vertical .table-hover.table-mc-blue > tbody > tr > td:hover {
background-color: #d0d9ff;
}
}
.table-striped.table-mc-light-blue > tbody > tr:nth-child(odd) > td,
.table-striped.table-mc-light-blue > tbody > tr:nth-child(odd) > th {
background-color: #e1f5fe;
}
.table-hover.table-mc-light-blue > tbody > tr:hover > td,
.table-hover.table-mc-light-blue > tbody > tr:hover > th {
background-color: #b3e5fc;
}
@media screen and (max-width: 767px) {
.table-responsive-vertical .table-striped.table-mc-light-blue > tbody > tr > td,
.table-responsive-vertical .table-striped.table-mc-light-blue > tbody > tr:nth-child(odd) {
background-color: #ffffff;
}
.table-responsive-vertical .table-striped.table-mc-light-blue > tbody > tr > td:nth-child(odd) {
background-color: #e1f5fe;
}
.table-responsive-vertical .table-hover.table-mc-light-blue > tbody > tr:hover > td,
.table-responsive-vertical .table-hover.table-mc-light-blue > tbody > tr:hover {
background-color: #ffffff;
}
.table-responsive-vertical .table-hover.table-mc-light-blue > tbody > tr > td:hover {
background-color: #b3e5fc;
}
}
.table-striped.table-mc-cyan > tbody > tr:nth-child(odd) > td,
.table-striped.table-mc-cyan > tbody > tr:nth-child(odd) > th {
background-color: #e0f7fa;
}
.table-hover.table-mc-cyan > tbody > tr:hover > td,
.table-hover.table-mc-cyan > tbody > tr:hover > th {
background-color: #b2ebf2;
}
@media screen and (max-width: 767px) {
.table-responsive-vertical .table-striped.table-mc-cyan > tbody > tr > td,
.table-responsive-vertical .table-striped.table-mc-cyan > tbody > tr:nth-child(odd) {
background-color: #ffffff;
}
.table-responsive-vertical .table-striped.table-mc-cyan > tbody > tr > td:nth-child(odd) {
background-color: #e0f7fa;
}
.table-responsive-vertical .table-hover.table-mc-cyan > tbody > tr:hover > td,
.table-responsive-vertical .table-hover.table-mc-cyan > tbody > tr:hover {
background-color: #ffffff;
}
.table-responsive-vertical .table-hover.table-mc-cyan > tbody > tr > td:hover {
background-color: #b2ebf2;
}
}
.table-striped.table-mc-teal > tbody > tr:nth-child(odd) > td,
.table-striped.table-mc-teal > tbody > tr:nth-child(odd) > th {
background-color: #e0f2f1;
}
.table-hover.table-mc-teal > tbody > tr:hover > td,
.table-hover.table-mc-teal > tbody > tr:hover > th {
background-color: #b2dfdb;
}
@media screen and (max-width: 767px) {
.table-responsive-vertical .table-striped.table-mc-teal > tbody > tr > td,
.table-responsive-vertical .table-striped.table-mc-teal > tbody > tr:nth-child(odd) {
background-color: #ffffff;
}
.table-responsive-vertical .table-striped.table-mc-teal > tbody > tr > td:nth-child(odd) {
background-color: #e0f2f1;
}
.table-responsive-vertical .table-hover.table-mc-teal > tbody > tr:hover > td,
.table-responsive-vertical .table-hover.table-mc-teal > tbody > tr:hover {
background-color: #ffffff;
}
.table-responsive-vertical .table-hover.table-mc-teal > tbody > tr > td:hover {
background-color: #b2dfdb;
}
}
.table-striped.table-mc-green > tbody > tr:nth-child(odd) > td,
.table-striped.table-mc-green > tbody > tr:nth-child(odd) > th {
background-color: #d0f8ce;
}
.table-hover.table-mc-green > tbody > tr:hover > td,
.table-hover.table-mc-green > tbody > tr:hover > th {
background-color: #a3e9a4;
}
@media screen and (max-width: 767px) {
.table-responsive-vertical .table-striped.table-mc-green > tbody > tr > td,
.table-responsive-vertical .table-striped.table-mc-green > tbody > tr:nth-child(odd) {
background-color: #ffffff;
}
.table-responsive-vertical .table-striped.table-mc-green > tbody > tr > td:nth-child(odd) {
background-color: #d0f8ce;
}
.table-responsive-vertical .table-hover.table-mc-green > tbody > tr:hover > td,
.table-responsive-vertical .table-hover.table-mc-green > tbody > tr:hover {
background-color: #ffffff;
}
.table-responsive-vertical .table-hover.table-mc-green > tbody > tr > td:hover {
background-color: #a3e9a4;
}
}
.table-striped.table-mc-light-green > tbody > tr:nth-child(odd) > td,
.table-striped.table-mc-light-green > tbody > tr:nth-child(odd) > th {
background-color: #f1f8e9;
}
.table-hover.table-mc-light-green > tbody > tr:hover > td,
.table-hover.table-mc-light-green > tbody > tr:hover > th {
background-color: #dcedc8;
}
@media screen and (max-width: 767px) {
.table-responsive-vertical .table-striped.table-mc-light-green > tbody > tr > td,
.table-responsive-vertical .table-striped.table-mc-light-green > tbody > tr:nth-child(odd) {
background-color: #ffffff;
}
.table-responsive-vertical .table-striped.table-mc-light-green > tbody > tr > td:nth-child(odd) {
background-color: #f1f8e9;
}
.table-responsive-vertical .table-hover.table-mc-light-green > tbody > tr:hover > td,
.table-responsive-vertical .table-hover.table-mc-light-green > tbody > tr:hover {
background-color: #ffffff;
}
.table-responsive-vertical .table-hover.table-mc-light-green > tbody > tr > td:hover {
background-color: #dcedc8;
}
}
.table-striped.table-mc-lime > tbody > tr:nth-child(odd) > td,
.table-striped.table-mc-lime > tbody > tr:nth-child(odd) > th {
background-color: #f9fbe7;
}
.table-hover.table-mc-lime > tbody > tr:hover > td,
.table-hover.table-mc-lime > tbody > tr:hover > th {
background-color: #f0f4c3;
}
@media screen and (max-width: 767px) {
.table-responsive-vertical .table-striped.table-mc-lime > tbody > tr > td,
.table-responsive-vertical .table-striped.table-mc-lime > tbody > tr:nth-child(odd) {
background-color: #ffffff;
}
.table-responsive-vertical .table-striped.table-mc-lime > tbody > tr > td:nth-child(odd) {
background-color: #f9fbe7;
}
.table-responsive-vertical .table-hover.table-mc-lime > tbody > tr:hover > td,
.table-responsive-vertical .table-hover.table-mc-lime > tbody > tr:hover {
background-color: #ffffff;
}
.table-responsive-vertical .table-hover.table-mc-lime > tbody > tr > td:hover {
background-color: #f0f4c3;
}
}
.table-striped.table-mc-yellow > tbody > tr:nth-child(odd) > td,
.table-striped.table-mc-yellow > tbody > tr:nth-child(odd) > th {
background-color: #fffde7;
}
.table-hover.table-mc-yellow > tbody > tr:hover > td,
.table-hover.table-mc-yellow > tbody > tr:hover > th {
background-color: #fff9c4;
}
@media screen and (max-width: 767px) {
.table-responsive-vertical .table-striped.table-mc-yellow > tbody > tr > td,
.table-responsive-vertical .table-striped.table-mc-yellow > tbody > tr:nth-child(odd) {
background-color: #ffffff;
}
.table-responsive-vertical .table-striped.table-mc-yellow > tbody > tr > td:nth-child(odd) {
background-color: #fffde7;
}
.table-responsive-vertical .table-hover.table-mc-yellow > tbody > tr:hover > td,
.table-responsive-vertical .table-hover.table-mc-yellow > tbody > tr:hover {
background-color: #ffffff;
}
.table-responsive-vertical .table-hover.table-mc-yellow > tbody > tr > td:hover {
background-color: #fff9c4;
}
}
.table-striped.table-mc-amber > tbody > tr:nth-child(odd) > td,
.table-striped.table-mc-amber > tbody > tr:nth-child(odd) > th {
background-color: #fff8e1;
}
.table-hover.table-mc-amber > tbody > tr:hover > td,
.table-hover.table-mc-amber > tbody > tr:hover > th {
background-color: #ffecb3;
}
@media screen and (max-width: 767px) {
.table-responsive-vertical .table-striped.table-mc-amber > tbody > tr > td,
.table-responsive-vertical .table-striped.table-mc-amber > tbody > tr:nth-child(odd) {
background-color: #ffffff;
}
.table-responsive-vertical .table-striped.table-mc-amber > tbody > tr > td:nth-child(odd) {
background-color: #fff8e1;
}
.table-responsive-vertical .table-hover.table-mc-amber > tbody > tr:hover > td,
.table-responsive-vertical .table-hover.table-mc-amber > tbody > tr:hover {
background-color: #ffffff;
}
.table-responsive-vertical .table-hover.table-mc-amber > tbody > tr > td:hover {
background-color: #ffecb3;
}
}
.table-striped.table-mc-orange > tbody > tr:nth-child(odd) > td,
.table-striped.table-mc-orange > tbody > tr:nth-child(odd) > th {
background-color: #fff3e0;
}
.table-hover.table-mc-orange > tbody > tr:hover > td,
.table-hover.table-mc-orange > tbody > tr:hover > th {
background-color: #ffe0b2;
}
@media screen and (max-width: 767px) {
.table-responsive-vertical .table-striped.table-mc-orange > tbody > tr > td,
.table-responsive-vertical .table-striped.table-mc-orange > tbody > tr:nth-child(odd) {
background-color: #ffffff;
}
.table-responsive-vertical .table-striped.table-mc-orange > tbody > tr > td:nth-child(odd) {
background-color: #fff3e0;
}
.table-responsive-vertical .table-hover.table-mc-orange > tbody > tr:hover > td,
.table-responsive-vertical .table-hover.table-mc-orange > tbody > tr:hover {
background-color: #ffffff;
}
.table-responsive-vertical .table-hover.table-mc-orange > tbody > tr > td:hover {
background-color: #ffe0b2;
}
}
.table-striped.table-mc-deep-orange > tbody > tr:nth-child(odd) > td,
.table-striped.table-mc-deep-orange > tbody > tr:nth-child(odd) > th {
background-color: #fbe9e7;
}
.table-hover.table-mc-deep-orange > tbody > tr:hover > td,
.table-hover.table-mc-deep-orange > tbody > tr:hover > th {
background-color: #ffccbc;
}
@media screen and (max-width: 767px) {
.table-responsive-vertical .table-striped.table-mc-deep-orange > tbody > tr > td,
.table-responsive-vertical .table-striped.table-mc-deep-orange > tbody > tr:nth-child(odd) {
background-color: #ffffff;
}
.table-responsive-vertical .table-striped.table-mc-deep-orange > tbody > tr > td:nth-child(odd) {
background-color: #fbe9e7;
}
.table-responsive-vertical .table-hover.table-mc-deep-orange > tbody > tr:hover > td,
.table-responsive-vertical .table-hover.table-mc-deep-orange > tbody > tr:hover {
background-color: #ffffff;
}
.table-responsive-vertical .table-hover.table-mc-deep-orange > tbody > tr > td:hover {
background-color: #ffccbc;
}
}
@endpush
