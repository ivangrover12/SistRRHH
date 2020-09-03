<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aviso de afiliacion y reingreso del trabajador</title>
</head>
<body>
    <br>
<div class="doc">
    <div class="head center"> Contrato de trabajo a plazo fijo Nº {{ $contract->contract_number }} </div>
    <div class="content">
        <p class="text" style="text-indent: 0">
        Entre la Empresa Comercial "<span class="title-text">PASTELERIA VICTORIA'S</span>", representada por su Ge­rente General, <span class="title-text" style="text-align: justify;">Sra. {{ Util::fullName($mae->employee) }} con C.I. No. {{ Util::ciExt($mae->employee) }}, en su calidad de {{ $mae->position->name }} de la PASTELERIA VICTORIA'S</span>, designado <!-- mediante Resolución Suprema Nº {{ $company->directors_designation_number }} --> en fecha {{ Carbon::parse($company->directors_designation_date)->ISOFormat('LL') }}, y por otra parte <span class="title-text up">{{ Util::fullName($contract->employee) }} con C.I. N° {{ Util::ciExt($contract->employee) }} </span>, mayor de edad y hábil por derecho, con domicilio en la ciudad de {{ $contract->employee->location }}, que en lo sucesivo se denominará el <span class="title-text">“CONTRATADO”</span> quienes celebran el presente contrato, de acuerdo a los términos y condiciones siguientes:
        </p>
        <p>
            <span class="title-text">CLÁUSULA PRIMERA. -</span> El Sr. <span class="title-text up">{{ Util::fullName($contract->employee) }}. es contratado por la empresa para prestar servicios en la Planta Indutrial PASTELERIA VICTORIA'S situado en la Av. Arica N° 200. de la ciudad de El Alto
        </p>
        @if ($contract->hiring_reference_number)
        <p>
            Mediante CITE: <span class="">{{ $contract->rrhh_cite }} </span> de fecha {{ Carbon::parse($contract->rrhh_cite_date)->day }} de {{ Carbon::parse($contract->rrhh_cite_date)->formatLocalized('%B') }} de {{ Carbon::parse($contract->rrhh_cite_date)->year }}, como resultado de la Convocatoria: {{ $contract->hiring_reference_number }} dentro del Proceso de Contratación para el cargo de: <span class="title-text">“{{ $contract->position->name }}”</span>, el Director General Ejecutivo y la Jefatura de la Unidad de Recursos Humanos de la PASTELERIA VICTORIA'S, instruyen la elaboración de Contrato del Personal de <span class="cap">{{ Util::fullName($contract->employee, 'lowercase') }}</span>.
        </p>
        @else
            @if ($contract->performance_cite)
            <p>
                Mediante CITE: <span class="">{{ $contract->rrhh_cite }} </span> de fecha {{ Carbon::parse($contract->rrhh_cite_date)->day }} de {{ Carbon::parse($contract->rrhh_cite_date)->formatLocalized('%B') }} de {{ Carbon::parse($contract->rrhh_cite_date)->year }}, como resultado de la Evaluación de Personal realizado mediante CITE: {{ $contract->performance_cite }}, el Director General Ejecutivo y la Jefatura de la Unidad de Recursos Humanos de PASTELERIA VICTORIA'S, instruyen la elaboración de Contrato del Personal de <span class="cap">{{ Util::fullName($contract->employee, 'lowercase') }}</span>.
            </p>
            @else
            <p>
                Mediante CITE: <span class="">{{ $contract->rrhh_cite }} </span> de fecha {{ Carbon::parse($contract->rrhh_cite_date)->day }} de {{ Carbon::parse($contract->rrhh_cite_date)->formatLocalized('%B') }} de {{ Carbon::parse($contract->rrhh_cite_date)->year }}, como resultado de la evaluación efectuada por parte del inmediato superior, en coordinación con el Director General Ejecutivo y la Jefatura de la Unidad de Recursos Humanos, se determinó la elaboración del Contrato del Personal de <span class="cap">{{ Util::fullName($contract->employee, 'lowercase') }}</span>.
            </p>
            @endif
        @endif

        <p>
            <span class="title-text">CLÁUSULA SEGUNDA (OBJETO). -</span> Por los antecedentes expuestos, la <span class="title-text">PASTELERIA VICTORIA'S</span> procede a suscribir el presente contrato con el <span class="title-text">CONTRATADO</span> para que desempeñe funciones como <span class="title-text up"> {{ $contract->position->name }} </span>
        </p>
        <!-- <p>
            Asimismo, se aclara que <span class="title-text">“VICTORIA”</span>, por razones de mejor servicio, podrá destinar al <span class="title-text">CONTRATADO</span> temporal o permanentemente a otra unidad, departamento o jefatura, debiendo previamente elaborarse el contrato modificatorio correspondiente.
        </p>
        <p>
            El <span class="title-text">CONTRATADO</span> podrá ejercer Interinato, sin descuidar las funciones para las que fue contratado, previa instrucción escrita de la Máxima Autoridad Ejecutiva y de acuerdo a las necesidades de <span class="title-text">VICTORIA</span>.
        </p> -->
        <p>
            <span class="title-text">CLÁUSULA TERCERA (PLAZO).</span> El plazo del presente contrato será a partir del {{ Carbon::parse($contract->start_date)->day }} de {{ Carbon::parse($contract->start_date)->formatLocalized('%B') }} del {{ Carbon::parse($contract->start_date)->year }} hasta el {{ Carbon::parse($contract->end_date)->day }} de {{ Carbon::parse($contract->end_date)->formatLocalized('%B') }} del {{ Carbon::parse($contract->end_date)->year }}, por tratarse de un contrato, queda sobreentendido que el mismo quedará fenecido en la fecha señalada en la presente cláusula, salvando la previsión contenida en la Cláusula Décima del presente contrato.
        </p>
        @php($schedule = $contract->job_schedules[0])
        @php($turno1 = str_pad($schedule->start_hour,2,0,STR_PAD_LEFT).':'.str_pad($schedule->start_minutes,2,0,STR_PAD_LEFT).' a '.str_pad($schedule->end_hour,2,0,STR_PAD_LEFT).':'.str_pad($schedule->end_minutes,2,0,STR_PAD_LEFT))
        @if(isset($contract->job_schedules[1]))
        @php($schedule2 = $contract->job_schedules[1])
        @php($turno2 = ' y de '.str_pad($schedule2->start_hour,2,0,STR_PAD_LEFT).':'.str_pad($schedule2->start_minutes,2,0,STR_PAD_LEFT).' a '.str_pad($schedule2->end_hour,2,0,STR_PAD_LEFT).':'.str_pad($schedule2->end_minutes,2,0,STR_PAD_LEFT))
        @else
        @php($turno2 = '')
        @endif
        <p>
            <span class="title-text">CLÁUSULA CUARTA (JORNADA LABORAL). -</span> El horario de cumplimiento de funciones por parte del <span class="title-text">CONTRATADO</span> es de {{ $turno1 }}{{ $turno2 }}; asimismo la Entidad en caso de necesidad, establecerá horarios específicos diferentes para fines empresariales.
        </p>
       <!--  <p>
            <span class="title-text">CLÁUSULA QUINTA (VACACIÓN). -</span> Por tratarse de un contrato eventual, el <span class="title-text">CONTRATADO</span> no tiene derecho a vacación.
        </p> -->
        <p>
            <span class="title-text">CLÁUSULA QUINTA (REMUNERACION). -</span> El <span class="title-text">CONTRATADO</span> percibirá el sueldo mensual de <span class="title-text">Bs.- {{ Util::format_number($contract->position->charge->base_wage) }}.- ( {{ Util::convertir($contract->position->charge->base_wage) }} Bolivianos)</span> sueldo que será pagado y ejecutado por fondos de la Empresa.
        </p>
        <p>
            Asimismo, de la remuneración acordada la <span class="title-text">PASTELERIA VICTORIA'S</span> hará las retenciones impositivas aplicables si correspondiera y los descuentos determinados por Ley. La forma de pago será la establecida por <span class="title-text">PASTELERIA VICTORIA'S</span> pudiendo el pago efectuarse por la Unidad de Tesorería o a través de una entidad bancaria.
        </p>
        <p>
            <span class="title-text">CLÁUSULA SEXTA (VIAJES POR COMISIÓN). -</span> El <span class="title-text">CONTRATADO</span> podrá realizar viajes oficiales, debiendo adecuarse a la escala correspondiente para lo cual deberán asignarse los recursos para pasajes y viáticos en las partidas respectivas.
        </p>
        <p>
            <span class="title-text">CLÁUSULA SEPTIMA (OBLIGACIONES). -</span> Siendo el presente contrato de trabajo a plazo fijo, queda sobre­entendido que el mismo quedará fenecido en la fecha señalada en la cláu­sula anterior, salvando la previsión contenida en la última parte de la mis­ma cláusula, así como también las disposiciones del Art.17 de la Ley Ge­neral del Trabajo, referidas a las causas de rescisión del contrato y que se relacionen con el Art. 16 del citado cuerpo legal.
        </p>
        <p>
            Se deja establecido que los resultados del trabajo que obtenga y/o desarrolle el <span class="title-text">CONTRATADO</span> emergente del presente contrato, serán de propiedad, uso y disposición exclusiva de la <span class="title-text">PASTELERIA VICTORIA'S</span>.
        </p>
        <P>
            Las partes señalan como domicilios especiales para efectos le­gales consiguientes, los señalados en la parte introductoria de este contra­to, sometiéndose en cuanto a la interpretación y aplicación de los términos y cláusulas que contiene, bajo la jurisdicción y competencia de los tribuna­les laborales de la ciudad de El Alto.
        </P>
        <p>
            <span class="title-text">CLÁUSULA OCTAVA (CONFORMIDAD). -</span> Las partes manifiestan su conformidad con cada una de las cláusulas estipuladas en el presente contrato y se comprometen a su fiel y estricto cumplimiento, firmando al pie en tres ejemplares con un sólo tenor y un mismo efecto.
        </p>
        <p class="center">
            La Paz, {{ Carbon::parse($contract->start_date)->day }} de {{ Carbon::parse($contract->start_date)->formatLocalized('%B') }} del {{ Carbon::parse($contract->start_date)->year }}
        </p>

        <p class="firma center title-text">
            {{ Util::fullName($contract->employee) }}<br>
            C.I. N° {{ Util::ciExt($contract->employee) }}
        </p>
    </div>
</div>
</body>
</html>
