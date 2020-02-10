<!DOCTYPE html>
<html>
<head>
	<title>HTML to API - Invoice</title>
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<!-- <link rel="stylesheet" href="sass/main.css" media="screen" charset="utf-8"/> -->
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta http-equiv="content-type" content="text-html; charset=utf-8">
	<style type="text/css">
    html, body, div, span, applet, object, iframe,
    h1, h2, h3, h4, h5, h6, p, blockquote, pre,
    a, abbr, acronym, address, big, cite, code,
    del, dfn, em, img, ins, kbd, q, s, samp,
    small, strike, strong, sub, sup, tt, var,
    b, u, i, center,
    dl, dt, dd, ol, ul, li,
    fieldset, form, label, legend,
    table, caption, tbody, tfoot, thead, tr, th, td,
    article, aside, canvas, details, embed,
    figure, figcaption, footer, header, hgroup,
    menu, nav, output, ruby, section, summary,
    time, mark, audio, video {
      margin: 0;
      padding: 0;
      border: 0;
      font: inherit;
      font-size: 100%;
      vertical-align: baseline;
    }

    html {
      line-height: 1;
    }

    ol, ul {
      list-style: none;
    }

    table {
      border-collapse: collapse;
      border-spacing: 0;
    }

    caption, th, td {
      text-align: left;
      font-weight: normal;
      vertical-align: middle;
    }

    q, blockquote {
      quotes: none;
    }
    q:before, q:after, blockquote:before, blockquote:after {
      content: "";
      content: none;
    }

    a img {
      border: none;
    }

    article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
      display: block;
    }

    body {
      font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
      font-weight: 300;
      font-size: 12px;
      margin: 0;
      padding: 0;
      color: #555555;
    }
    body a {
      text-decoration: none;
      color: inherit;
    }
    body a:hover {
      color: inherit;
      opacity: 0.7;
    }
    body .container {
      min-width: 460px;
      margin: 0 auto;
      padding: 0 20px;
    }
    body .clearfix:after {
      content: "";
      display: table;
      clear: both;
    }
    body .left {
      float: left;
    }
    body .right {
      float: right;
    }
    body .helper {
      display: inline-block;
      height: 100%;
      vertical-align: middle;
    }
    body .no-break {
      page-break-inside: avoid;
    }

    header {
      margin-top: 15px;
      margin-bottom: 45px;
    }
    header figure {
      float: left;
      margin-right: 10px;
      width: 65px;
      height: 70px;
      background-color: #66BDA9;
      text-align: center;
    }
    header figure img {
      margin-top: 10px;
    }
    header .company-info {
      float: right;
      color: #66BDA9;
      line-height: 14px;
    }
    header .company-info .address, header .company-info .phone, header .company-info .email {
      position: relative;
    }
    header .company-info .address img, header .company-info .phone img {
      margin-top: 2px;
    }
    header .company-info .email img {
      margin-top: 3px;
    }
    header .company-info .title {
      color: #66BDA9;
      font-weight: 400;
      font-size: 1.33333333333333em;
    }
    header .company-info .icon {
      position: absolute;
      left: -15px;
      top: 1px;
      width: 10px;
      height: 10px;
      background-color: #66BDA9;
      text-align: center;
      line-height: 0;
    }

    section .details {
      min-width: 440px;
      /* margin-bottom: 40px; */
      padding: 5px 10px;
      /* background-color: #CC5A6A; */
      background-color: #f5f5f5;
      /* color: #ffffff; */
      color: #333;
      line-height: 20px;
    }

    .section .details-title{
      margin-bottom: 0!important;
    }
    section .details .client {
      width: 50%;
    }
    section .details .client .name {
      /* font-size: 1.16666666666667em; */
      font-size: 13px;
      font-weight: 600;
    }
    section .details .data {
      width: 50%;
      font-weight: 600;
      text-align: right;
    }
    section .details .title {
      margin-bottom: 5px;
      font-size: 1.33333333333333em;
      text-transform: uppercase;
    }
    section table {
      width: 100%;
      margin-bottom: 20px;
      table-layout: fixed;
      border-collapse: collapse;
      border-spacing: 0;
    }
    section table .qty, section table .unit, section table .total {
      width: 15%;
    }
    section table .desc {
      width: 55%;
    }
    section table thead {
      display: table-header-group;
      vertical-align: middle;
      border-color: inherit;
    }
    section table thead th {
      padding: 8px 10px;
      /* background: #66BDA9; */
      background: #e7461f;
      /* border-right: 5px solid #FFFFFF; */
      /* border-right: 5px solid #FFFFFF; */
      color: white;
      text-align: center;
      font-weight: 600;
      font-size: 12px;
      text-transform: uppercase;
    }
    section table thead th:last-child {
      border-right: none;
    }
    section table tbody td {
      padding: 7px 10px;
      text-align: center;
      border-right: 1px solid #99999959;
    }
    table.items tbody tr:last-child{
          border-bottom: 1px solid #99999959;
      }
    section table tbody td:last-child {
      border-right: none;
    }
    section table tbody td.desc {
      text-align: left;
    }
    section table tbody td.total {
      color: #d34336;
      font-weight: 600;
      text-align: right;
    }
    section table tbody h3 {
      margin-bottom: 5px;
      color: #d34336;
      font-weight: 600;
    }
    section table.grand-total {
      margin-bottom: 50px;
    }
    section table.grand-total tbody tr td {
      padding: 0px 10px 12px;
      border: none;
      background-color: #f5f5f5;
      color: #787887;
      font-weight: 300;
      text-align: right;
    }
    section table.grand-total tbody tr:first-child td {
      padding-top: 12px;
    }
    section table.grand-total tbody tr:last-child td {
      background-color: transparent;
    }
    section table.grand-total tbody .grand-total {
      padding: 0;
    }
    section table.grand-total tbody .grand-total div {
      float: right;
      padding: 11px 10px;
      background-color: #e7461f;
      color: #ffffff;
      font-weight: 600;
      min-width: 260px;
    }
    section table.grand-total tbody .grand-total div span {
      display: inline-block;
      margin-right: 20px;
      width: 80px;
    }

    footer {
      margin-bottom: 15px;
      padding: 0 5px;
    }
    footer .thanks {
      margin-bottom: 40px;
      color: #d34336;
      font-size: 1.16666666666667em;
      font-weight: 600;
    }
    footer .notice {
      margin-bottom: 15px;
    }
    footer .end {
      padding-top: 5px;
      border-top: 2px solid #f2f3f2;;
      text-align: center;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2
    }

    .client.left img{
      width: 120px;
      margin: 0 auto;
    }
    .page-title{
      font-size: 13px;
      font-weight: 600;
      text-transform: uppercase;
    }

	</style>
</head>

<body>

	<section>
		<div class="container">
<!-- 
			<header class="clearfix" style="width: 100%;">
				<div class="container">
					<figure>
						<img class="logo" src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+Cjxzdmcgd2lkdGg9IjQ4cHgiIGhlaWdodD0iNDdweCIgdmlld0JveD0iMCAwIDQ4IDQ3IiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIj4KICAgIDwhLS0gR2VuZXJhdG9yOiBTa2V0Y2ggMy40LjEgKDE1NjgxKSAtIGh0dHA6Ly93d3cuYm9oZW1pYW5jb2RpbmcuY29tL3NrZXRjaCAtLT4KICAgIDx0aXRsZT5ob21lNDwvdGl0bGU+CiAgICA8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4KICAgIDxkZWZzPjwvZGVmcz4KICAgIDxnIGlkPSJQYWdlLTEiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiIHNrZXRjaDp0eXBlPSJNU1BhZ2UiPgogICAgICAgIDxnIGlkPSJJTlZPSUNFLTMiIHNrZXRjaDp0eXBlPSJNU0FydGJvYXJkR3JvdXAiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0zOC4wMDAwMDAsIC00MS4wMDAwMDApIiBmaWxsPSIjRkZGRkZGIj4KICAgICAgICAgICAgPGcgaWQ9IlpBR0xBVkxKRSIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzAuMDAwMDAwLCAyNS4wMDAwMDApIj4KICAgICAgICAgICAgICAgIDxnIGlkPSJob21lNCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoOC4wMDAwMDAsIDE2LjAwMDAwMCkiIHNrZXRjaDp0eXBlPSJNU1NoYXBlR3JvdXAiPgogICAgICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik00Ni40MzQ3MTE0LDIxLjI5MTAxNzMgTDM5LjI3NzM2MTQsMTMuNjY2ODQ1MyBMMzkuMjc3MzYxNCw0Ljg1OTI0NjYgQzM5LjI3NzM2MTQsMy4yNjcwODUyMSAzOC4wNjYxNTc5LDEuOTc2Mzk3NDIgMzYuNTY4NTk4NCwxLjk3NjM5NzQyIEMzNS4wNzQ4NTIyLDEuOTc2Mzk3NDIgMzMuODYzNjQ4NywzLjI2NzA4NTIxIDMzLjg2MzY0ODcsNC44NTkyNDY2IEwzMy44NjM2NDg3LDcuODk5NzUwNjEgTDI4LjUzNDE4NjQsMi4yMjI3ODA2OCBDMjUuODk5MDY4LC0wLjU4MjEyOTY0NCAyMS4zMTc3MywtMC41NzcxNzkxMzEgMTguNjg5MDQ2NiwyLjIyNzczMTE5IEwwLjc5MjIxNTc1OSwyMS4yOTEwMTczIEMtMC4yNjM5NTI3NTQsMjIuNDE4NTkyIC0wLjI2Mzk1Mjc1NCwyNC4yNDMzMDA2IDAuNzkyMjE1NzU5LDI1LjM2ODg0NDMgQzEuODQ5NDU2NzcsMjYuNDk2NDE5IDMuNTY1Njg1OTEsMjYuNDk2NDE5IDQuNjIxODU0NDIsMjUuMzY4ODQ0MyBMMjIuNTE2Nzc4Niw2LjMwNTU1ODI0IEMyMy4xMDAwOTYzLDUuNjg3NzU5NTEgMjQuMTI3NDI2Nyw1LjY4Nzc1OTUxIDI0LjcwNzQwNzcsNi4zMDM2NTQyIEw0Mi42MDUwNzI3LDI1LjM2ODg0NDMgQzQzLjEzNjE5NTcsMjUuOTMyNTY4MiA0My44Mjc5NTQ1LDI2LjIxMzIyNDMgNDQuNTE5NzEzMywyNi4yMTMyMjQzIEM0NS4yMTI3ODI5LDI2LjIxMzIyNDMgNDUuOTA1OTcxNywyNS45MzI1NjgyIDQ2LjQzNTE4ODEsMjUuMzY4ODQ0MyBDNDcuNDkxODMzMiwyNC4yNDMzMDA2IDQ3LjQ5MTgzMzIsMjIuNDE4NTkyIDQ2LjQzNDcxMTQsMjEuMjkxMDE3MyBMNDYuNDM0NzExNCwyMS4yOTEwMTczIFoiIGlkPSJGaWxsLTEiPjwvcGF0aD4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMjQuNTUzODAyNywxMS43NzgyODc3IEMyNC4wMzM4ODEzLDExLjIyNDg0NTcgMjMuMTkyMjExNywxMS4yMjQ4NDU3IDIyLjY3MzcyMDMsMTEuNzc4Mjg3NyBMNi45MzE2NDk1NiwyOC41NDE3NDI4IEM2LjY4MzA2OTIyLDI4LjgwNjAyNDEgNi41NDI0NTMzMSwyOS4xNjc1Mzg2IDYuNTQyNDUzMzEsMjkuNTQ0Mjg1MyBMNi41NDI0NTMzMSw0MS43NzE0MTk3IEM2LjU0MjQ1MzMxLDQ0LjY0MDMwNTkgOC43MjYxNzA3OCw0Ni45NjYyODU3IDExLjQxOTQ0MjIsNDYuOTY2Mjg1NyBMMTkuMjEzMTM4OCw0Ni45NjYyODU3IEwxOS4yMTMxMzg4LDM0LjEwOTAzOTkgTDI4LjAxMjM1ODQsMzQuMTA5MDM5OSBMMjguMDEyMzU4NCw0Ni45NjYyODU3IEwzNS44MDY2NTA4LDQ2Ljk2NjI4NTcgQzM4LjQ5OTkyMjIsNDYuOTY2Mjg1NyA0MC42ODM1MjA1LDQ0LjY0MDMwNTkgNDAuNjgzNTIwNSw0MS43NzE0MTk3IEw0MC42ODM1MjA1LDI5LjU0NDI4NTMgQzQwLjY4MzUyMDUsMjkuMTY3NTM4NiA0MC41NDM4NTc5LDI4LjgwNjAyNDEgNDAuMjk0NDQzNCwyOC41NDE3NDI4IEwyNC41NTM4MDI3LDExLjc3ODI4NzcgWiIgaWQ9IkZpbGwtMyI+PC9wYXRoPgogICAgICAgICAgICAgICAgPC9nPgogICAgICAgICAgICA8L2c+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4=" alt="">
					</figure>

					<div class="company-info">
						<h2 class="title">{{$shipping_address['name']}}</h2>
						<div class="address">
							<span class="icon"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjYuNDIycHgiIGhlaWdodD0iNi43OTJweCINCgkgdmlld0JveD0iMCAwIDYuNDIyIDYuNzkyIiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IDAgMCA2LjQyMiA2Ljc5MiIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8dGl0bGU+RmlsbCAxICsgRmlsbCAyPC90aXRsZT4NCjxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPg0KPGc+DQoJPGVsbGlwc2UgZmlsbD0ibm9uZSIgY3g9IjMuMjExIiBjeT0iMS45MzciIHJ4PSIxLjAwNiIgcnk9IjAuOTY4Ii8+DQoJPHBhdGggZmlsbD0iI0ZGRkZGRiIgZD0iTTQuNzkyLDQuODMySDQuMTUxQzQuMDg5LDQuOTMxLDQuMDMsNS4wMjMsMy45Nyw1LjExNGgwLjY4M2wxLjE2NCwxLjM5OUgwLjYwNUwxLjc3LDUuMTE0aDAuNjgxDQoJCWMtMC4wNTktMC4wOTEtMC4xMTktMC4xODMtMC4xOC0wLjI4MkgxLjYyOUwwLDYuNzkyaDYuNDIzTDQuNzkyLDQuODMyeiIvPg0KCTxwYXRoIGZpbGw9IiNGRkZGRkYiIGQ9Ik01LjIyMiwxLjkzN0M1LjIyMiwwLjg2OSw0LjMyMywwLDMuMjA5LDBDMi4wOTgsMCwxLjE5OCwwLjg2OSwxLjE5OCwxLjkzNw0KCQljMCwxLjA3MSwyLjAxMiwzLjg3NSwyLjAxMiwzLjg3NVM1LjIyMiwzLjAwOCw1LjIyMiwxLjkzN3ogTTIuMjA1LDEuOTM3YzAtMC41MzUsMC40NTEtMC45NjgsMS4wMDYtMC45NjgNCgkJYzAuNTU2LDAsMS4wMDcsMC40MzUsMS4wMDcsMC45NjhjMCwwLjUzNi0wLjQ1MSwwLjk3LTEuMDA3LDAuOTdTMi4yMDUsMi40NzMsMi4yMDUsMS45Mzd6Ii8+DQo8L2c+DQo8L3N2Zz4NCg==" alt="">
							</span>
							<p>
								{{$shipping_address['address']}},<br>
								{{$shipping_address['postal_code']}}, {{$shipping_address['city']}}, {{$shipping_address['country']}}
							</p>
						</div>
						<div class="phone">
							<span class="icon">
								<img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjUuNXB4IiBoZWlnaHQ9IjUuNDk2cHgiDQoJIHZpZXdCb3g9IjAuMjUgMC4yNSA1LjUgNS40OTYiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMC4yNSAwLjI1IDUuNSA1LjQ5NiIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8dGl0bGU+RmlsbCAxPC90aXRsZT4NCjxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPg0KPGcgaWQ9IlBhZ2UtMSIgc2tldGNoOnR5cGU9Ik1TUGFnZSI+DQoJPGcgaWQ9IklOVk9JQ0UtMyIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTQyNS4wMDAwMDAsIC03OC4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNBcnRib2FyZEdyb3VwIj4NCgkJPGcgaWQ9IlpBR0xBVkxKRSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzAuMDAwMDAwLCAyNS4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNMYXllckdyb3VwIj4NCgkJCTxnIGlkPSJQSE9ORSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzkzLjAwMDAwMCwgNTEuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TU2hhcGVHcm91cCI+DQoJCQkJPHBhdGggaWQ9IkZpbGwtMSIgZmlsbD0iI0ZGRkZGRiIgZD0iTTcuNjY2LDYuODJMNi44OTIsNy41OUM2Ljg1Niw3LjYyOCw2LjgxMSw3LjY2MSw2Ljc1NSw3LjY4OA0KCQkJCQlDNi42OTgsNy43MTUsNi42NDMsNy43MzIsNi41ODksNy43NGMtMC4wMDQsMC0wLjAxNiwwLjAwMi0wLjAzNSwwLjAwNFM2LjUxLDcuNzQ2LDYuNDc5LDcuNzQ2DQoJCQkJCWMtMC4wNzQsMC0wLjE5My0wLjAxMi0wLjM1OC0wLjAzN1M1Ljc1Myw3LjYyMSw1LjUxNSw3LjUyMmMtMC4yMzktMC4wOTktMC41MS0wLjI0Ny0wLjgxMi0wLjQ0Ng0KCQkJCQlDNC4zOTksNi44NzksNC4wNzcsNi42MDcsMy43MzYsNi4yNjJDMy40NjQsNS45OTQsMy4yMzksNS43MzgsMy4wNjEsNS40OTNDMi44ODIsNS4yNDksMi43MzgsNS4wMjIsMi42MjksNC44MTUNCgkJCQkJQzIuNTIxLDQuNjA3LDIuNDM5LDQuNDE5LDIuMzg1LDQuMjVjLTAuMDU0LTAuMTY5LTAuMDkxLTAuMzE0LTAuMTEtMC40MzdjLTAuMDItMC4xMjMtMC4wMjctMC4yMTktMC4wMjMtMC4yODkNCgkJCQkJczAuMDA2LTAuMTA4LDAuMDA2LTAuMTE2YzAuMDA4LTAuMDU0LDAuMDI1LTAuMTEsMC4wNTItMC4xNjZjMC4wMjctMC4wNTYsMC4wNi0wLjEwMiwwLjA5OS0wLjEzN2wwLjc3NC0wLjc3NA0KCQkJCQlDMy4yMzcsMi4yNzcsMy4yOTksMi4yNSwzLjM2OSwyLjI1YzAuMDUsMCwwLjA5NSwwLjAxNSwwLjEzNCwwLjA0M2MwLjAzOSwwLjAyOSwwLjA3MiwwLjA2NSwwLjA5OSwwLjEwOGwwLjYyMywxLjE4Mg0KCQkJCQlDNC4yNiwzLjY0Niw0LjI3LDMuNzEzLDQuMjU0LDMuNzg3UzQuMjA2LDMuOTIzLDQuMTU1LDMuOTc0TDMuODcsNC4yNTlDMy44NjIsNC4yNjcsMy44NTUsNC4yNzksMy44NDksNC4yOTYNCgkJCQkJQzMuODQzLDQuMzE0LDMuODQsNC4zMjksMy44NCw0LjM0QzMuODU2LDQuNDIyLDMuODkxLDQuNTE1LDMuOTQ1LDQuNjJDMy45OTIsNC43MTMsNC4wNjMsNC44MjYsNC4xNjEsNC45Ng0KCQkJCQljMC4wOTcsMC4xMzQsMC4yMzUsMC4yODgsMC40MTQsMC40NjNDNC43NDksNS42MDIsNC45MDQsNS43NCw1LjA0LDUuODRjMC4xMzYsMC4wOTksMC4yNSwwLjE3MiwwLjM0LDAuMjE4DQoJCQkJCUM1LjQ3Miw2LjEwNCw1LjU0MSw2LjEzMyw1LjU5LDYuMTQzbDAuMDczLDAuMDE0YzAuMDA4LDAsMC4wMjEtMC4wMDIsMC4wMzgtMC4wMDhTNS43Myw2LjEzNiw1LjczOCw2LjEyOEw2LjA3LDUuNzkNCgkJCQkJYzAuMDctMC4wNjIsMC4xNTEtMC4wOTMsMC4yNDQtMC4wOTNjMC4wNjYsMCwwLjExOSwwLjAxMiwwLjE1OCwwLjAzNWwxLjEyOSwwLjY2M0M3LjY4NCw2LjQ0Niw3LjczMiw2LjUxLDcuNzQ4LDYuNTg4DQoJCQkJCUM3Ljc1OSw2LjY3Nyw3LjczMiw2Ljc1NSw3LjY2Niw2LjgyeiIvPg0KCQkJPC9nPg0KCQk8L2c+DQoJPC9nPg0KPC9nPg0KPC9zdmc+DQo=" alt="">
							</span>
							<a href="tel:602-519-0450">{{$shipping_address['phone']}}</a>
						</div>
						<div class="email">
							<span class="icon"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+Cjxzdmcgd2lkdGg9IjZweCIgaGVpZ2h0PSI0cHgiIHZpZXdCb3g9IjAgMCA2IDQiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeG1sbnM6c2tldGNoPSJodHRwOi8vd3d3LmJvaGVtaWFuY29kaW5nLmNvbS9za2V0Y2gvbnMiPgogICAgPCEtLSBHZW5lcmF0b3I6IFNrZXRjaCAzLjQuMSAoMTU2ODEpIC0gaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoIC0tPgogICAgPHRpdGxlPmVtYWlsMTk8L3RpdGxlPgogICAgPGRlc2M+Q3JlYXRlZCB3aXRoIFNrZXRjaC48L2Rlc2M+CiAgICA8ZGVmcz48L2RlZnM+CiAgICA8ZyBpZD0iUGFnZS0xIiBzdHJva2U9Im5vbmUiIHN0cm9rZS13aWR0aD0iMSIgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIiBza2V0Y2g6dHlwZT0iTVNQYWdlIj4KICAgICAgICA8ZyBpZD0iSU5WT0lDRS0zIiBza2V0Y2g6dHlwZT0iTVNBcnRib2FyZEdyb3VwIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtNDI1LjAwMDAwMCwgLTkzLjAwMDAwMCkiIGZpbGw9IiNGRkZGRkYiPgogICAgICAgICAgICA8ZyBpZD0iTUFJTCIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNDIzLjAwMDAwMCwgOTAuMDAwMDAwKSI+CiAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMiw3IEw4LDcgTDgsMyBMMiwzIEwyLDcgWiBNNC45OTk4MTU2Miw1LjQ3MDEzMjgyIEwyLjUzOTEzNTI0LDMuMjk2NjA4NzkgTDcuNDYwODY0NzYsMy4yOTY2MDg3OSBMNC45OTk4MTU2Miw1LjQ3MDEzMjgyIFogTTQuMDE5NTQ0NTcsNC45OTkzMDQ2MSBMMi4yOTQ5MjAyNSw2LjUyMjU4ODcyIEwyLjI5NDkyMDI1LDMuNDc1OTI3NzcgTDQuMDE5NTQ0NTcsNC45OTkzMDQ2MSBaIE00LjI0MzIwMDg5LDUuMTk2NjExMTEgTDQuOTk5ODE1NjIsNS44NjQ4Mzg1NSBMNS43NTY0MzAzNSw1LjE5NjYxMTExIEw3LjQ2MjMzOTgyLDYuNzAzMjk4NDkgTDIuNTM3NjYwMTgsNi43MDMyOTg0OSBMNC4yNDMyMDA4OSw1LjE5NjYxMTExIFogTTUuOTgwMDg2NjYsNC45OTkzMDQ2MSBMNy43MDQ3MTA5OCwzLjQ3NTkyNzc3IEw3LjcwNDcxMDk4LDYuNTIyNTg4NzIgTDUuOTgwMDg2NjYsNC45OTkzMDQ2MSBaIiBpZD0iZW1haWwxOSIgc2tldGNoOnR5cGU9Ik1TU2hhcGVHcm91cCI+PC9wYXRoPgogICAgICAgICAgICA8L2c+CiAgICAgICAgPC9nPgogICAgPC9nPgo8L3N2Zz4=" alt="">
							</span>
							<a href="mailto:company@example.com">{{$shipping_address['email']}}</a>
						</div>
					</div>
				</div>
      </header> -->
      
			<div class="details details-title clearfix" style="width: 100%;">
				<div class="client left">
          <img src="amref-white.png">
          <div style="font-size: 13px;font-weight:600;">
            <span>AMREF ENTERPRISES</span> | <span style="color: #d34336;">AMREF HEALTH AFRICA</span>
          </div>
				</div>
				<div class="data right">
          <div class="title page-title">Purchase Order</div>
          <div class="title"></div>
          <div class="date">
            PO Number: #{{$order_data['po_number']}}<br>
            PO Date: {{$order_data['po_date']}}<br>
            PO Due Date: {{$order_data['po_due_date']}}
          </div>
				</div>
			</div>

			<div class="details clearfix" style="width: 100%; background:#fff;">
				<div class="client left">
          <div class="title page-title">To:</div>
          <p>{{$mailing_address['first_name']}} {{$mailing_address['other_name']}}</p>
          <p>{{$mailing_address['company']}}</p>
					<p>{{$mailing_address['address']}},</p>
					<p>{{$mailing_address['postal_code']}}, {{$mailing_address['city']}}, {{$mailing_address['country']}}</p>
					<a>{{$mailing_address['email']}}</a>
				</div>
				<div class="data right">
					<div class="title page-title">Ship To:</div>
          <p>
              {{$shipping_address['name']}},<br>
              {{$shipping_address['address']}},<br>
              {{$shipping_address['postal_code']}},{{$shipping_address['city']}}, {{$shipping_address['country']}}<br>
              {{$shipping_address['email']}},<br>
            </p>
				</div>
			</div>

			<table border="0" class="items" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<th class="qty">Quantity</th>
						<th class="desc">Description</th>
						<th class="unit">Unit price</th>
						<th class="total">Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="qty">30</td>
						<td class="desc">Amoxyl</td>
						<td class="unit">$40.00</td>
						<td class="total">$1,200.00</td>
					</tr>
					<tr>
						<td class="qty">80</td>
						<td class="desc">Amoxyl</td>
						<td class="unit">$40.00</td>
						<td class="total">$3,200.00</td>
					</tr>
					<tr>
						<td class="qty">20</td>
						<td class="desc">Amoxyl</td>
						<td class="unit">$40.00</td>
						<td class="total">$800.00</td>
					</tr>
				</tbody>
			</table>
			<div class="no-break">
				<table class="grand-total">
					<tbody>
						<tr class="total">
							<td class="qty"></td>
							<td class="desc"></td>
							<td class="unit">SUBTOTAL:</td>
							<td class="total">$5,200.00</td>
						</tr>
						<tr class="total">
							<td class="qty"></td>
							<td class="desc"></td>
							<td class="unit">TAX 25%:</td>
							<td class="total">$1,300.00</td>
						</tr>
						<tr class="total">
							<td class="grand-total" colspan="4"><div><span>GRAND TOTAL:</span>$6,500.00</div></td>
						</tr>
					</tbody>
				</table>
			</div>
			<footer>
				<div class="container">
					<div class="thanks">Thank you!</div>
					<div class="notice">
						<div>Message:</div>
						<div>A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
          </div>
          <div class="notice">
              <div>Memo:</div>
              <div>A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
            </div>
					<div class="end">Purchase Order was created on a computer and is valid without the signature and seal.</div>
				</div>
			</footer>
		</div>
	</section>
</body>

</html>
