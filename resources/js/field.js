Nova.booting((Vue, router, store) => {
  Vue.component('index-laravel-nova-currency-field', require('./components/IndexField'))
  Vue.component('detail-laravel-nova-currency-field', require('./components/DetailField'))
  Vue.component('form-laravel-nova-currency-field', require('./components/FormField'))
})
