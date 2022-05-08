import counterReducer from "./counter.js";
import vriendenReducer from "./Vrienden.js"

const reducers = Redux.combineReducers({counterState:counterReducer, vriendenState:vriendenReducer})

/* STORE */
const store = Redux.createStore(reducers, window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__());

export default store;
