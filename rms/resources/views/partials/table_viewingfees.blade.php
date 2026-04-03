 


 @if (count($viewingfees) > 0)
 <table class="table table-bordered table-sm table-nowrap mb-0">
                       <thead>
                           <tr>
                               <th style="width:40%">Property</th>
                               <th>Total Collected</th>
                               <th>Company Income</th>

                           </tr>
                       </thead>

                      
                       <tbody>

                           @foreach ($placementfees as $placementfee)
                               <tr>
                               <td>{{ $placementfee->apartment->name}}</td>
                               <td>{{ number_format($placementfee->smnt)}}</td>
                               <td>{{ number_format($placementfee->smnt / 2)}}</td>

                              
                               
                           </tr>
                           @endforeach
                            

                       </tbody>
                   </table>
@endif

