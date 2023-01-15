<table>
	<tr>
		<td><h3 class="color-green font-weight-bold">এখলাসপুর সেন্টার অফ হেলথ</h3></td>
		<td></td>
		<td>
			<table>
				<tr>
					<td>
						<h1>Photo</h1>
					</td>
					<td>
						<table>
							<tr>
								<th style="text-align: left;">Name</th>
								<td><b>:</b> {{$info->name}}</td>
							</tr>
							<tr>
								<th style="text-align: left;">Age</th>
								<td><b>:</b> {{$info->age}}</td>
							</tr>
							<tr>
								<th style="text-align: left;">Sex</th>
								<td><b>:</b> {{$info->gender == 0?'Male':'Female'}}</td>
							</tr>
							<tr>
								<th style="text-align: left;">Address</th>
								<td><b>:</b> {{$info->address}}</td>
							</tr>
							<tr>
								<th style="text-align: left;">ECOH ID</th>
								<td><b>:</b> {{$info->centerid}}</td>
							</tr>
							<tr>
								<th style="text-align: left;">Date</th>
								<td><b>:</b> {{date('d M Y', strtotime($info->meet_date))}}</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" style="border-top: 1px solid #2b6749;">
			<table>
				<tr>
					<td style="border-right: 1px solid #2b6749;">
						<b>On Examination</b>:
						<hr>
						<table>
							<tr>
								<td>BP </td>
								<td><b>:</b> {{$info->bp}} mm of Hg</td>
							</tr>
							<tr>
								<td>Pulse </td>
								<td><b>:</b> {{$info->pulse}}/min</td>
							</tr>
							<tr>
								<td>Temp. </td>
								<td><b>:</b> {{$info->temp}}°F</td>
							</tr>
							<tr>
								<td>Weight </td>
								<td><b>:</b> {{$info->weight}}kg</td>
							</tr>
							<tr>
								<td>Height </td>
								<td><b>:</b> {{$info->height}}cm</td>
							</tr>
							<tr>
								<td>O<sub>2</sub> Satu. </td>
								<td><b>:</b> {{$info->oxygen}}%</td>
							</tr>
						</table>

						@if($info->predochos || $info->pretreatment)
						<b>Prevoius History:</b>
						<hr>
						<table>
							<tr>
								<td>Dr/H. N.</td>
								<td><b>:</b> {{$info->predochos}}</td>
							</tr>
							<tr>
								<td>Invest </td>
								<td><b>:</b> @php($preinvs = \App\Model\Inv::where('info_id',$info->piid)->get())
								@foreach($preinvs as $preinv)
								{{$preinv->test_name}} - {{$preinv->result}};
								@endforeach</td>
							</tr>
							<tr>
								<td>Treat.</td>
								<td><b>:</b> {{$info->pretreatment}}</td>
							</tr>
						</table>
						@endif

						<b>Chief Complaints:</b>
						<hr>
						<table>
							<tr>
								<td colspan="2">{{$info->cc}}</td>
							</tr>
							
						</table>

						<b>Investigation Find:</b>
						<hr>
						<table>
							<tr>
								<td>
									@if($info->test == !null)
										@php($givenTest = explode(', ',$info->test))
										@foreach($givenTest as $gTest)
											@php($getTest = \App\Model\Test::where('test_name',$gTest)->first())
											@if($getTest)
			    								@php($getResult = \App\Model\Report::where('test_id',$getTest->id)->where('history_id',$info->hid)->first())
			    								@if($getResult)
			    									{{$gTest}}: {{$getResult->result}} {{$getResult->remark == null ? '':'- '.$getResult->remark}}<br>
			    								@else
			    									{{$gTest}}: <span style="color: red;">Not Added Yet</span> <br>
			    								@endif
			    							@endif
										@endforeach
									@else
									No Investigation Find
									@endif
								</td>
							</tr>
						</table>


						<b>Diagnosis:</b>
						<hr>
						<table>
							<tr>
								<td colspan="2">{{$info->diagnosis}}</td>
							</tr>
							
						</table>

						@if($info->suggested_test)
						<b>Suggested Test:</b>
						<hr>
						<table>
							<tr>
								<td colspan="2">{{$info->suggested_test}}</td>
							</tr>
							
						</table>
						@endif

					</td>
					<td colspan="2" top="0">
						<table class="table table-sm">
							@foreach($prescriptions as $prescription)
							<tr>
								<td></td>
								<td>
									<span class="doctor"> 
										{{$loop->index + 1}}. 
										@php($cat = substr($prescription->cat, 0, 3))
										@if($cat == 'Syr')
										Syp.
										@else
										{{$cat}}.
										@endif
									</span>
								</td>
								<td><span class="doctor"> {{$prescription->medname}} - {{$prescription->mes}}</span></td>
								<td></td>
								<td><span class="doctor"> {{$prescription->dose_duration == '0' ? '':$prescription->dose_duration}} {{$prescription->dose_duration_type}}</span></td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td><span class="doctor"> {{$prescription->dose_time}}</span></td>
								<td><span class="doctor"> 
									@if($prescription->dose_qty == '১/২')
									<sup>১</sup>&frasl;<sub>২</sub>
									@elseif($prescription->dose_qty == '৩/৪')
									<sup>৩</sup>&frasl;<sub>৪</sub>
									@elseif($prescription->dose_qty == '১.১/২')
									১<sup>১</sup>&frasl;<sub>২</sub>
									@elseif($prescription->dose_qty == '২.১/২')
									২<sup>১</sup>&frasl;<sub>২</sub>
									@else
									{{$prescription->dose_qty}}
									@endif
									{{$prescription->dose_qty_type}} করে {{$prescription->dose_eat}}</span></td>
								<td></td>
							</tr>
							@endforeach
							<td></td>
							<br>
							<br>
							<br>
							<tr>
								<td colspan="4">
									<h6>উপদেশঃ</h6>
									<hr>
									@if($info->advices)
										@php($advices = explode('।, ',$info->advices))
										<ul>
										@foreach($advices as $advice)
										<li>{{$advice}} {{$loop->index +1 == count($advices) ? '':'।'}}</li>
										@endforeach
									@endif
								</td>
								<td>
									<h6>Electronic Signature</h6>
									<hr>
									<h5>{{$info->dname}}</h5>
									<span>{{$info->education}}</span><br>
									<span>{{$info->spc}}</span><br>
									<span>BM&DC Reg. No: {{$info->regi_no}}</span>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" style="text-align: center; border-top: 1px solid #2b6749;">
			২ মাস পর আসবেন। পরবর্তী ভিজিটের সময় অবশ্যই ব্যবস্থাপত্র সাথে আনবেন। ধন্যবাদ।
		</td>
	</tr>
	<tr>
		<td colspan="3" style="text-align: center; border-top: 1px solid #2b6749;">
			<span><strong>এখলাসপুর, মতলব উত্তর, চাঁদপুর ৩৬৪১</strong></span> <br>
			মোবাইল: 01766020707 | ইমেইল: chandpurecoh3641@gmail.com | ওয়েবসাইট: www.ecohbd.org <br>  Developed & Maintenance by <a href="https://devmizanur.com" target="_blank"> www.devmizanur.com</a>
		</td>
	</tr>
</table>