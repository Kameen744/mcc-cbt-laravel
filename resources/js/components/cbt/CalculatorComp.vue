<template>
  <!-- Vue Calculator
A PEN BY Paolo Duzioni
  Modified by Kamal-->
  <div class="calculator">
    <div class="display bg-gray-900 p-2 d-flex justify-content-between mb-3">
      <i class="text-small">
        <i v-if="!display">{{ a }}</i>
        <i>{{ operator }}</i>
        <i>{{ b }}</i>
      </i>
      <b class>{{ display }}</b>
    </div>
    <div class="keyboard">
      <div class="panel-a">
        <div class="top-buttons">
          <button class="btn primary" @click="clear">
            <span>C</span>
          </button>
          <button class="btn" @click="setNumber('.')">
            <span>.</span>
          </button>
        </div>
        <div class="numbers">
          <button class="btn" @click="setNumber('9')">
            <span>9</span>
          </button>
          <button class="btn" @click="setNumber('8')">
            <span>8</span>
          </button>
          <button class="btn" @click="setNumber('7')">
            <span>7</span>
          </button>
          <button class="btn" @click="setNumber('6')">
            <span>6</span>
          </button>
          <button class="btn" @click="setNumber('5')">
            <span>5</span>
          </button>
          <button class="btn" @click="setNumber('4')">
            <span>4</span>
          </button>
          <button class="btn" @click="setNumber('3')">
            <span>3</span>
          </button>
          <button class="btn" @click="setNumber('2')">
            <span>2</span>
          </button>
          <button class="btn" @click="setNumber('1')">
            <span>1</span>
          </button>
          <button class="btn" @click="setNumber('0')">
            <span>0</span>
          </button>
        </div>
      </div>
      <div class="panel-b">
        <button class="btn" @click="operator = '+'">
          <span>+</span>
        </button>
        <button class="btn" @click="operator = '-'">
          <span>-</span>
        </button>
        <button class="btn" @click="operator = 'X'">
          <span>X</span>
        </button>
        <button class="btn" @click="operator = '/'">
          <span>/</span>
        </button>
        <button class="btn primary" @click="calculate">
          <span>=</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      a: "",
      b: "",
      tot: 0,
      info: "",
      display: 0,
      operator: null
    };
  },

  methods: {
    setNumber(num) {
      if (this.operator === null) {
        this.a += num;
        // this.display = this.a;
      } else {
        this.b += num;
        // this.display = this.b;
      }
    },

    calculate() {
      switch (this.operator) {
        case "+":
          this.tot = parseFloat(this.a) + parseFloat(this.b);
          break;
        case "-":
          this.tot = parseFloat(this.a) - parseFloat(this.b);
          break;
        case "X":
          this.tot = parseFloat(this.a) * parseFloat(this.b);
          break;
        case "/":
          this.tot = parseFloat(this.a) / parseFloat(this.b);
          break;
      }
      this.display = this.tot;
      this.a = "" + this.tot + "";
      this.b = "";
      this.operator = null;
    },

    clear() {
      this.a = "";
      this.b = "";
      this.tot = 0;
      this.display = 0;
      this.operator = null;
    }
  }
};
</script>

<style scoped>
.calculator {
  max-width: 100%;
}
.calculator .display {
  color: #fff;
  border-radius: 3px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.15);
}
.calculator .brand {
  margin: 0.6rem 0 0.3rem;
  padding: 0 0.3rem;
  text-align: right;
  font-size: 0.65em;
  color: rgba(255, 255, 255, 0.85);
}
.calculator .keyboard {
  display: flex;
  flex-wrap: wrap;
}
.calculator .keyboard .btn {
  margin: 0;
  padding: 0;
  height: 3.6rem;
  line-height: 3rem;
  text-align: center;
  font-family: inherit;
  font-size: 1.25em;
  border: none;
  background: transparent;
  outline: none;
}
.calculator .keyboard .btn:hover span {
  background: #4d4d4d;
}
.calculator .keyboard .btn span {
  display: block;
  margin: 0.3rem;
  color: #fff;
  background: #333;
  border-radius: 3px;
  transition: background-color 0.4s;
}
.calculator .keyboard .btn.primary:hover span {
  background: #b4bbc2;
}
.calculator .keyboard .btn.primary span {
  background: #082519;
}
.calculator .keyboard .panel-a {
  width: 75%;
}
.calculator .keyboard .panel-a .top-buttons .btn {
  width: 33.3%;
}
.calculator .keyboard .panel-a .top-buttons .btn:last-of-type {
  float: right;
}
.calculator .keyboard .panel-a .top-buttons .btn span {
  font-weight: bold;
}
.calculator .keyboard .panel-a .numbers {
  display: flex;
  flex-wrap: wrap;
  flex-direction: row-reverse;
  align-items: flex-end;
  align-content: flex-end;
}
.calculator .keyboard .panel-a .numbers .btn {
  width: 33.3%;
}
.calculator .keyboard .panel-a .numbers .btn:nth-child(10) {
  width: 100%;
}
.calculator .keyboard .panel-b {
  display: flex;
  flex-direction: column;
  width: 25%;
}
.calculator .keyboard .panel-b .btn {
  width: 100%;
}
.calculator .keyboard .panel-b .btn span {
  font-weight: bold;
}
</style>
