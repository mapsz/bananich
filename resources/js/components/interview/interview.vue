<template>
<div>

  <center>
    <div v-if="current == 0" style="width:50%">
      <h5>Пожалуйста, оцените каждый пункт по шкале от 0 до 10, где 0- это прямо совсем-совсем никуда не годится, а 10- огонь как круто!</h5> 
    </div>
  </center>
  
  <div v-if="current < 7">
    <div  class="container" style="margin-top: 40px; display: flex; width: 100%; justify-content: center;">
      <b-form-group :label="questions[current].cap">
        <b-form-radio-group
          v-if="questions[current].type == 'n'"
          v-model="answer"
          :options="options"
          name="radio-inline"
        ></b-form-radio-group>
        <b-form-input
          v-else
          v-model="answer"
          type="text"
          required
        ></b-form-input>        
      </b-form-group>
    </div>
    <div class="d-flex" style="justify-content: center;">
      <button @click="putAnswer()" class="btn-primary btn">Далее</button>
    </div>
  </div>

  <div v-else class="container"  style="margin-top: 40px;">
    Большое вам спасибо, за то, что уделили время на наш опрос! Мы очень внимательно читаем каждый отзыв и работаем над улучшениями! И, как и обещали, ваш промокод в подарок: Opros07
  </div>

</div>
</template>

<script>
export default {
props: ['user'],
data(){return{
  current:0,
  questions:[
    {
      'cap':'Качество самого сервиса (вежливость оператора, скорость и качество отработки запросов и т.д)',
      'type':'n',
    },
    {
      'cap':'Качество доставки (вежливость и пунктуальность курьеров)',
      'type':'n',
    },
    {
      'cap':'Качество самой продукции',
      'type':'n',
    },
    {
      'cap':'Качество каких товаров вас огорчило, если такое случилось?',
      'type':'t',
    },
    {
      'cap':'Что в нашем ассортименте вам бы еще хотелось увидеть?',
      'type':'t',
    },
    {
      'cap':'Что-то еще, над чем нам надо поработать (тут можно прямо совсем невежливо честно, нам будет полезно:_))?',
      'type':'t',
    },
    {
      'cap':'Оцените, пожалуйста, от 0 до 10 вероятность того, что вы будете рекомендовать нас друзьям.',
      'type':'n',
    },
  ],
  answer:"",
  options: [
    { text: '1', value: '1' },
    { text: '2', value: '2' },
    { text: '3', value: '3' },
    { text: '4', value: '4' },
    { text: '5', value: '5' },
    { text: '6', value: '6' },
    { text: '7', value: '7' },
    { text: '8', value: '8' },
    { text: '9', value: '9' },
    { text: '10', value: '10' }
  ]
}},

methods:{
  async putAnswer(){
      let r = await this.jugeAx('/put/interviews',
      {
        question:this.current,
        answer:this.answer,
        user_id:this.user,
      },
      'put'
    );
    if(!r) return;
    
    this.current++;
    this.answer = "";
  }

},
}
</script>

<style>

</style>