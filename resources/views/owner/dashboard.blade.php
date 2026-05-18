@extends('owner.layouts.app')

@section('title', 'Панель владельца')

@section('content')

<div class="container-fluid py-3">

<div class="mini-calendar">

    {{-- HEADER --}}
    <div class="mini-header">
        <button id="prevMonth">‹</button>
        <div id="monthName"></div>
        <button id="nextMonth">›</button>
    </div>

    {{-- CLOCK --}}
    <div class="mini-clock">
        <div id="liveTime"></div>
        <div id="liveDate"></div>
    </div>

    {{-- DAYS --}}
    <div class="mini-weekdays">
        <div>Пн</div><div>Вт</div><div>Ср</div>
        <div>Чт</div><div>Пт</div><div>Сб</div><div>Вс</div>
    </div>

    <div class="mini-days" id="daysContainer"></div>

    {{-- BOOKINGS --}}
    <div class="mini-bookings">
        <div class="mini-title">Брони</div>
        <div id="bookingList"></div>
    </div>

</div>

</div>

<style>

body{
    background:#eef1f6;
}

/* CALENDAR */
.mini-calendar{
    width:320px;
    background:#1e1e1e;
    color:white;
    border-radius:18px;
    padding:12px;
    box-shadow:0 10px 25px rgba(0,0,0,.2);
}

.mini-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
}

.mini-header button{
    width:28px;
    height:28px;
    border-radius:8px;
    border:none;
    background:#2c2c2c;
    color:white;
    cursor:pointer;
}

#monthName{
    font-size:14px;
    font-weight:600;
}

.mini-clock{
    text-align:center;
    margin-bottom:10px;
}

#liveTime{
    font-size:22px;
    font-weight:300;
}

#liveDate{
    font-size:11px;
    color:#aaa;
}

.mini-weekdays{
    display:grid;
    grid-template-columns:repeat(7,1fr);
    font-size:10px;
    color:#888;
    text-align:center;
}

.mini-days{
    display:grid;
    grid-template-columns:repeat(7,1fr);
    gap:4px;
    margin-top:6px;
}

.day{
    aspect-ratio:1;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:11px;
    border-radius:6px;
    cursor:pointer;
    transition:.2s;
}

.day:hover{
    background:#333;
}

/* 🟢 booked */
.day.booked{
    background:#28a745 !important;
    font-weight:700;
}

/* 🚫 past days */
.day.disabled{
    opacity:.3;
    pointer-events:none;
    color:#666;
}

/* 🔵 TODAY */
.day.today{
    background:#0d6efd !important;
    color:#fff;
    font-weight:700;
    border:1px solid #0a58ca;
}

/* BOOKINGS */
.mini-bookings{
    margin-top:10px;
    border-top:1px solid #333;
    padding-top:8px;
}

.mini-title{
    font-size:12px;
    margin-bottom:6px;
    color:#bbb;
}

.booking-item{
    background:rgba(40,167,69,.15);
    border:1px solid rgba(40,167,69,.3);
    padding:6px;
    border-radius:8px;
    margin-bottom:5px;
    font-size:11px;
}

.booking-service{
    color:#28a745;
    font-weight:600;
}

.booking-time{
    font-size:10px;
    color:#b6f5c1;
}

</style>

<script>

document.addEventListener('DOMContentLoaded', function () {

let currentDate = new Date();

/* ================= LIMIT (3 MONTHS) ================= */
let minDate = new Date();
minDate.setHours(0,0,0,0);

let maxDate = new Date();
maxDate.setMonth(maxDate.getMonth() + 2);

/* ================= TODAY FUNCTION ================= */
function getToday(){
    const t = new Date();
    t.setHours(0,0,0,0);
    return t;
}

/* ================= CLOCK ================= */
function clock(){
    const now = new Date();

    document.getElementById('liveTime').innerText =
        now.toLocaleTimeString('ru-RU',{hour:'2-digit',minute:'2-digit'});

    document.getElementById('liveDate').innerText =
        now.toLocaleDateString('ru-RU',{day:'2-digit',month:'short'});
}

setInterval(clock,1000);
clock();

/* ================= RENDER ================= */
const daysContainer = document.getElementById('daysContainer');
const monthName = document.getElementById('monthName');

function render(){

    daysContainer.innerHTML = '';

    const y = currentDate.getFullYear();
    const m = currentDate.getMonth();

    const first = new Date(y,m,1);
    const last = new Date(y,m+1,0);

    const months = ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'];

    monthName.innerText = months[m] + ' ' + y;

    let start = first.getDay();
    if(start === 0) start = 7;

    for(let i=1;i<start;i++){
        daysContainer.appendChild(document.createElement('div'));
    }

    for(let d=1; d<=last.getDate(); d++){

        const el = document.createElement('div');
        el.classList.add('day');
        el.innerText = d;

        const today = getToday();

        const current = new Date(y,m,d);
        current.setHours(0,0,0,0);

        /* 🚫 past days */
        if(current < today){
            el.classList.add('disabled');
        }

        /* 🔵 today */
        if(current.getTime() === today.getTime()){
            el.classList.add('today');
        }

        el.onclick = () => {

            if(el.classList.contains('disabled')) return;

            document.querySelectorAll('.day')
                .forEach(x=>x.classList.remove('active'));

            el.classList.add('active');

            const date =
                y+'-'+String(m+1).padStart(2,'0')+'-'+String(d).padStart(2,'0');

            loadBookings(date);
        };

        daysContainer.appendChild(el);
    }

    loadMonth(y,m);
}

render();

/* ================= MONTH CONTROL ================= */
document.getElementById('prevMonth').onclick = ()=>{

    let temp = new Date(currentDate);
    temp.setMonth(temp.getMonth()-1);

    if(temp < minDate) return;

    currentDate.setMonth(currentDate.getMonth()-1);
    render();
};

document.getElementById('nextMonth').onclick = ()=>{

    let temp = new Date(currentDate);
    temp.setMonth(temp.getMonth()+1);

    if(temp > maxDate) return;

    currentDate.setMonth(currentDate.getMonth()+1);
    render();
};

/* ================= BOOKINGS DAY ================= */
function loadBookings(date){

fetch('/owner/bookings/day/'+date)
.then(r=>r.json())
.then(data=>{

let html='';

if(data.length===0){
html='<div style="color:#777;font-size:11px">Нет броней</div>';
}else{
data.forEach(b=>{
html+=`
<div class="booking-item">

    <div class="booking-service">
        ${b.service?.name ?? 'Service'}
    </div>

    <div class="booking-time">
        ${b.start_time}
    </div>

</div>`;
});
}

document.getElementById('bookingList').innerHTML=html;

});

}

/* ================= MONTH BOOKED DAYS ================= */
function loadMonth(y,m){

fetch(`/owner/bookings/month/${y}-${String(m+1).padStart(2,'0')}`)
.then(r=>r.json())
.then(days=>{

document.querySelectorAll('.day')
    .forEach(el=>el.classList.remove('booked'));

days.forEach(date=>{
    const d = new Date(date).getDate();

    document.querySelectorAll('.day').forEach(el=>{
        if(+el.innerText === d){
            el.classList.add('booked');
        }
    });
});

});

}

/* ================= AUTO UPDATE TODAY ================= */
setInterval(() => {

    const now = new Date();

    if (
        now.getDate() !== currentDate.getDate() ||
        now.getMonth() !== currentDate.getMonth() ||
        now.getFullYear() !== currentDate.getFullYear()
    ) {
        currentDate = new Date();
        render();
    }

}, 60000);

});

</script>

@endsection