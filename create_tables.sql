create table medicine(
    medicine_id int,
    medicine_name varchar(30),
    price double not null,
    primary key(medicine_id)
);

create table department(
    department_code int,
    department_name varchar(30) not null,
    hod_id int,
    primary key(department_code)
);

create table doctor(
    doctor_id int,
    doctor_name varchar(30) not null,
    highest_degree varchar(10) not null,
    department_code int,
    dob date,
    login_password varchar(30),
    mail varchar(50),
    primary key(doctor_id),
    foreign key(department_code) references department(department_code)
);

create table patient(
    patient_id int,
    patient_name varchar(30) not null,
    house_no varchar(10),
    street_name varchar(30),
    state_name varchar(30),
    pin_code int,
    age int,
    dob date,
    gender char(1),
    login_password varchar(30),
    wallet double,
    mail varchar(50),
    primary key(patient_id)
);

create table nurse(
    nurse_id int,
    nurse_name varchar(30) not null,
    room_id int,
    primary key(nurse_id),
    foreign key(room_id) references room(room_id)
);

create table room(
    room_id int,
    no_of_beds int not null,
    beds_occupied int,
    nurse_id int,
    primary key(room_id),
    foreign key(nurse_id) references nurse(nurse_id)
);

create table admin(
    admin_id int,
    admin_name  varchar(30) not null,
    login_password varchar(30),
    mail varchar(50),
    primary key(admin_id)
);

create table prescription(
    prescription_id int,
    patient_id int,
    doctor_id int,
    medicine_id int,
    quantity int not null,
    bought_status char(1),
    primary key(prescription_id),
    foreign key(patient_id) references patient(patient_id),
    foreign key(doctor_id) references doctor(doctor_id),
    foreign key(medicine_id) references medicine(medicine_id)
);

create table payment(
    payment_id int,
    patient_id int,
    amount double not null,
    primary key(payment_id),
    foreign key(patient_id) references patient(patient_id)
);

create table phone(
    patient_id int,
    phone_no varchar(15),
    primary key(patient_id, phone_no),
    foreign key(patient_id) references patient(patient_id)
);

create table admit(
    patient_id int,
    room_id int,
    date_of_admit date,
    date_of_release date,
    primary key(patient_id, room_id),
    foreign key(patient_id) references patient(patient_id),
    foreign key(room_id) references room(room_id)
);

create table assign(
    patient_id int,
    doctor_id int,
    date_of_assign date not null,
    date_of_release date,
    primary key(patient_id, doctor_id),
    foreign key(patient_id) references patient(patient_id),
    foreign key(doctor_id) references doctor(doctor_id)
);