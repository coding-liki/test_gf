<template>
    <div class="container mt-5">
        <h1>Новый заказ</h1>
        <form v-on:submit="submitForm" id="newOrderForm" class="row">
            <div class="form-group col-12 col-md-6 col-lg-4">
                <label for="phoneInput">Телефон</label>
                <input v-model="phone" id="phoneInput" class="form-control" type="text" placeholder="Введите телефон" name="phone" required>
            </div>
            <div class="form-group col-12 col-md-6  col-lg-4">
                <label for="nameInput">Имя</label>
                <input v-model="name" id="nameInput" class="form-control" type="text" placeholder="Введите ваше имя" name="name" required>
            </div>
            <div class="form-group col-12 col-md-6 col-lg-4">
                <label for="tariffsList">Выберите тариф</label>
                <select v-model="tariff" class="form-control" name="tariff">
                    <option v-for="(the_tariff, index) in tariffs" :value="the_tariff.value" :key="index" >
                        {{ the_tariff.text }}
                    </option>
                </select>
            </div>
            <div class="form-group col-12 col-md-6 col-lg-12 m-0 mb-3 row">
                <label class="col-12 p-0">С какого дня начнём?</label>
                <template v-for="(day, index)  in tariffs[findTariffByValue(tariff)].days">
                    <div class="form-check col-12 col-md-6 col-lg-2" :key="index">
                    <input  type="radio" class="form-check-input" :value="day" name="first_fay" :id="index+'_day'" v-model="first_day" >
                    <label class="form-check-label" :for="index+'_day'" >{{day}}</label>
                    </div>
                </template>
            </div>
            <div class="form-group col-12">
                <label for="addressInput">Адрес</label>
                <input v-model="address" id="addressInput" class="form-control" type="text" placeholder="Введите ваш адрес" name="address" required>
            </div>
            <div id="message" v-if="show_message" class="col-12">
                <template v-if="add_errors.length > 0">
                    <span class="text-danger d-block col-12" v-for="(error, index) in add_errors" :key="index">{{error}}</span>
                </template>
                <template v-if="result_message && result_message.length > 0">
                    <span class="text-success d-block col-12">{{result_message}}</span>
                </template>
            </div>
            <div class="form-group text-center col-12">
                <button type="submit" class="btn btn-primary">Создать заказ</button>
            </div>
        </form>
    </div>
</template>


<script>
    export default {
        mounted() {
            this.getTariffs();
        },
        props: {
            
        },
        data: function(){
            return {
                name: "",
                phone: "",
                address: "",
                first_day: "Понедельник",
                tariff: 1,
                show_message: false,
                result_message: "",
                add_errors: [],
                tariffs: [
                    {
                        value: 1,
                        text: 'Первый тариф',
                        days: [
                            "Понедельник",
                            "Вторник",
                            "Среда"
                        ]
                    },
                    {
                        value: 2,
                        text: 'Второй тариф',
                        days: [
                            "Понедельник",
                            "Вторник"
                        ]
                    },
                    {
                        value: 3,
                        text: 'Третий тариф',
                        days: [
                            "Понедельник",
                            "Вторник",
                            "Среда",
                            "Четверг"
                        ]
                    }
                ]
            }
        },
        methods: {
            findTariffByValue: function(value){
                return this.tariffs.findIndex((element) => {
                    return element.value == value;
                });
            },
            submitForm: function(e){
                e.preventDefault();
                this.result_message = "";
                this.add_errors = [];
                var data = {
                    name: this.name,
                    phone: this.phone,
                    address: this.address,
                    tariff: this.tariff,
                    first_day: this.first_day
                }
                axios.post("/add_order", data).then(responce => {
                    console.log(responce.data);
                    this.show_message = true;
                    if(!responce.data.success || 'errors' in responce.data){
                        this.add_errors = responce.data.errors;
                    } else {
                        this.result_message = "Заказ #"+ responce.data.new_order_id + " добавлен успешно!";
                    }
                });
                console.log("Echho");
            },
            getTariffs: function(){
                axios.get('/get_tariffs').then(responce => responce.data).then(json => {
                    if(json.success){
                        this.tariffs = json.tariffs;
                    }
                })
            }
        }
    }
</script>