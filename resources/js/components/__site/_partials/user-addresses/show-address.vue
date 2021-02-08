<template>
<div>
  <div class="address-main">
    <span>{{address.street}}</span>
    <span>{{address.number ? address.number : ''}}</span>
    <span>{{address.appart ? 'кв.' + address.appart : ''}}</span>
  </div>
  <div class="address-other">
    <span v-if="address.porch">{{'Парадная ' + address.porch}}</span>
    <span v-if="address.stage">{{'Этаж ' + address.stage}}</span>
    <span v-if="address.intercom">{{'Домофон ' + address.intercom}}</span>
  </div>
</div>
</template>

<script>
export default {
props: ['address'],
}
</script>

<style scoped>

  .address-main{
    font-size:12pt;
  }
  .address-other{
    font-size:10pt;
  }
  .address-other span::after{
    content:',';
  }
  .address-other span:last-child::after{
    content:'';
  }

  /* Desktop */
  @media screen and (min-width: 992px){
    .address-main{
      font-size:14pt;
    }
    .address-other{
      font-size:12pt;
    }    
  }

</style>