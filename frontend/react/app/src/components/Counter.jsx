import { useState } from "react";

const Counter = () => {
    const [value, setValue] = useState(6);
    return (
        <div>
            <h1>{value}</h1>
            <button onClick={() => setValue(value + 1)}>+</button>
            <button onClick={() => setValue(value - 1)}>-</button>
        </div>
    );
};

export default Counter;
