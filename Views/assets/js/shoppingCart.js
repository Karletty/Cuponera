const $ = (id) => document.getElementsByClassName(id);

const inputs = $('product-cant');

for (let i = 0; i < inputs.length; i++) {
      const input = inputs[i];
      input.addEventListener('keydown', (e) => {
            key = e.key;
            if (!(key > 0 || key < 9 || key === 'Backspace')) {
                  e.preventDefault();
            }
      });

      input.addEventListener('keyup', () => {
            if (Number(input.value) > Number(input.attributes['maxcant'].value)) {
                  input.value = input.attributes['maxcant'].value;
            }
            if (Number(input.value) < 1) {
                  input.value = 1
            }
      })
}

const add = (position, max) => {
      if (inputs.length > 1 && Number(inputs[position].value) < max) {
            inputs[position].value = Number(inputs[position].value) + 1;
      } else if (inputs.length <= 1 && Number(inputs[0].value) < max) {
            inputs[0].value = Number(inputs[0].value) + 1;
      }
}

const reduce = (position) => {
      if (inputs.length > 1 && Number(inputs[position].value) > 1) {
            inputs[position].value = Number(inputs[position].value);
      } else if (inputs.length <= 1 && Number(inputs[0].value) > 1) {
            inputs[0].value = Number(inputs[0].value) - 1;
      }
}