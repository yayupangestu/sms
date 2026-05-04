<tr>
    <td class="vertical-cell">
        <div class="vertical-text-1">
          PRESS
        </div>
      </td>
      <td>
        <div class="wrap-columns">
          @foreach($pressData->where('qty_1', '!=', 0)->chunk(10) as $chunk)
            <div class="column">
              @foreach($chunk as $data)
                @php
                  $bgColor = $data->type_pallet === 'BESI' ? 'bg-besi' : ($data->type_pallet === 'BOX' ? 'bg-box' : ''); 
                @endphp
      
                @if($data->sts_qty_1 != 1)
                <div class="data-box {{ $bgColor }}">
                  <strong  style="font-size: 110%;">{{ $data->job_no }}:</strong>
                  <span  style="font-size: 120%" class="qty-box-white">
                    {{ $data->qty_1 }}
                    @if($data->qty_1 > 0)
                      <i class="fas fa-check-circle" style="color: green; margin-left: 5px;"></i>
                    @endif
                  </span> 
                </div>                        
                @endif
              @endforeach
            </div>
          @endforeach
        </div>
      </td>
      
    <!-- Kolom lainnya tetap kosong -->
      <td>
        <div class="wrap-columns">
          @foreach($pressData->where('qty_2', '!=', 0)->chunk(10) as $chunk)
            <div class="column">
              @foreach($chunk as $data)
                @php
                  $bgColor = $data->type_pallet === 'BESI' ? 'bg-besi' : ($data->type_pallet === 'BOX' ? 'bg-box' : ''); 
                @endphp
      
                @if($data->sts_qty_2 != 1)
                  <div class="data-box {{ $bgColor }}">
                    <strong style="font-size: 110%;">{{ $data->job_no }}:</strong>
                    <span  style="font-size: 120%" class="qty-box-white">
                      {{ $data->qty_2 }}
                      @if($data->qty_2 > 0)
                        <i class="fas fa-check-circle" style="color: green; margin-left: 5px;"></i>
                      @endif
                    </span> 
                  </div>
                @endif
              @endforeach
            </div>
          @endforeach
        </div>
      </td>
      <td>
        <div class="wrap-columns">
          @foreach($pressData->where('qty_3', '!=', 0)->chunk(10) as $chunk)
            <div class="column">
              @foreach($chunk as $data)
                @php
                  $bgColor = $data->type_pallet === 'BESI' ? 'bg-besi' : ($data->type_pallet === 'BOX' ? 'bg-box' : ''); 
                @endphp
      
                @if($data->sts_qty_1 != 1)
                <div class="data-box {{ $bgColor }}">
                  <strong  style="font-size: 110%;">{{ $data->job_no }}:</strong>
                  <span  style="font-size: 120%" class="qty-box-white">
                    {{ $data->qty_3 }}
                    @if($data->qty_3 > 0)
                      <i class="fas fa-check-circle" style="color: green; margin-left: 5px;"></i>
                    @endif
                  </span> 
                </div>                        
                @endif
              @endforeach
            </div>
          @endforeach
        </div>
      </td>
      <td>
        <div class="wrap-columns">
          @foreach($pressData->where('qty_4', '!=', 0)->chunk(10) as $chunk)
            <div class="column">
              @foreach($chunk as $data)
                @php
                  $bgColor = $data->type_pallet === 'BESI' ? 'bg-besi' : ($data->type_pallet === 'BOX' ? 'bg-box' : ''); 
                @endphp
      
                @if($data->sts_qty_1 != 1)
                <div class="data-box {{ $bgColor }}">
                  <strong  style="font-size: 110%;">{{ $data->job_no }}:</strong>
                  <span  style="font-size: 120%" class="qty-box-white">
                    {{ $data->qty_4 }}
                    @if($data->qty_4 > 0)
                      <i class="fas fa-check-circle" style="color: green; margin-left: 5px;"></i>
                    @endif
                  </span> 
                </div>                        
                @endif
              @endforeach
            </div>
          @endforeach
        </div>
      </td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
  </tr>