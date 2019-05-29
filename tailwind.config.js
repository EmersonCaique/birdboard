module.exports = {
  theme: {
    extend: {},
    colors: {
        'grey-light' : '#F5F6F9',
        'white' : '#ffff',
        'grey' : 'rgba(0,0,0,0.4)',
        'red' : '#B20000',
        'blue' : '#47cdff',
    },
    backgroundColor: theme => ({
        'blue' : theme('colors.blue'),
        'grey-light' : '#F5F6F9',
        'white' : '#ffff',
        'grey' : 'rgba(0,0,0,0.4)',
        'red' : '#B20000',


        'page' : 'var(--page-bg-color)',
        'card' : 'var(--card-bg-color)',
        'button' : 'var(--button-bg-color)',
        'nav' : 'var(--nav-bg-color)',

    })

  },
  variants: {},
  plugins: []
}
