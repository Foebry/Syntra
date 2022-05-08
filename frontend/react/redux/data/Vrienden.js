const rand = () => Math.random().toString(36).substring(2);

const initialState = [
    {
        id: rand(),
        name: "Koen"
    },
    {
        id: rand(),
        name:"Johan"
    },
    {
        id: rand(),
        name: "Kevin B."
    },
    {
        id: rand(),
        name: "Kevin"
    }
]

// action types
const ADD_FRIEND = "ADD_FRIEND";
const REMOVE_FRIEND = "REMOVE_FRIEND";

//action creators

export const addFriend = (str) => ({
    type: ADD_FRIEND,
    payload: {
        id: rand(),
        name: str
    }
});

export const removeFriend = (id) => ({
    type: REMOVE_FRIEND,
    payload: id,
});

const reducer = (state=initialState, {type, payload}) => {
    switch (type){
        case REMOVE_FRIEND: return state.filter(friend => friend.id !== payload)
        case ADD_FRIEND: return [...state, payload]
        default: return state;
    }
}

export default reducer;