<html>
    <head>
        <style>
            /** 
            * Define the width, height, margins and position of the watermark.
            **/
            #watermark {
                position: fixed;

                /** 
                    Set a position in the page for your image
                    This should center it vertically
                **/
                
                /** Change image dimensions**/
                width:    28cm;
                height:   19cm;

                /** Your watermark should be behind every content**/
                z-index:  -1;
            }

            @page { margin: .4in; }
            .bg { top: -.5in; right: -.5in; bottom: -.5in; left: -.5in; position: absolute; z-index: -1000;}

        </style>
    </head>
    <body>
        <img class="bg" src="{{url('storage/uploads/certificates/induction_certificate.png')}}" style="width: 8.5in;height: 12in" />
        <div style="text-align: center;margin-left: 2.5cm;margin-top: 7cm;width: 15cm">
            <h1 style="font-weight: bolder;width: 100%;text-align: center;">SISFS CERTIFIED EMPLOYEE</h1>
            <h3 style="width: 100%;text-align: center;">CERTIFICATE OF RECOGNITION</h3>
            <h5 style="width: 100%;text-align: center;">The certificate is proudly presented to</h5>
            <img style="border-radius: 100%;margin-top: 20px;width: 100px;height: 100px" src="{{url('storage')}}/{{$data['employee']->image}}">
            <h1 style="color: #708090">{{$data['employee']['first_name']}} {{$data['employee']['last_name']}}</h1>
            <h5 style="width: 100%;text-align: center;">{{$data['employee']['employee_no']}}</h5>

            <p style="width: 100%;text-align: center;font-size: 12px">The above individual has satisfactorily completed the SISFS Induction Programme and is recognized by SISFS as a certified employee/contractor of the SISFS. </p>
            <p style="width: 100%;text-align: center;font-size: 12px">This certificate of recognition demonstrates the commitment of SISFS and the above recipient to provide excellence in products and services to the Maintenance & Cleaning Industry.</p>

            <p style="width: 100%;text-align: center;font-size: 12px">This is computer generated certificate.</p>
            <p style="width: 100%;text-align: center;font-size: 12px">Certificate Reg No. {{$data['reg_no']}}</p>
        </div>
    </body>
</html>