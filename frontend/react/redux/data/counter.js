/* INITIAL STATE */
const initialState = {
  counter: 6,
};
/* ACTION TYPES */
const INCREMENT = "INCREMENT";
const DECREMENT = "DECREMENT";
const MULTIPLY_BY_5 = "MULTIPLY_BY_5";
/* ACTION CREATORS */
export const increment = () => ({
  type: INCREMENT,
});
export const decrement = () => ({
  type: DECREMENT,
});
export const multiplyBy5 = () => ({
  type: MULTIPLY_BY_5,
});
/* REDUCER */
export default (state = initialState, { type, payload }) => {
  switch (type) {
    case INCREMENT:
      return { counter: state.counter + 1 };
    case DECREMENT:
      return { counter: state.counter - 1 };
    case MULTIPLY_BY_5:
      return { counter: state.counter * 5 };
    default:
      return state;
  }
};
