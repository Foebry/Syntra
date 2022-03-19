import { useState } from "react";
import Person from "./Person";

const Name = () => {
    const [name, setName] = useState("Joske");
    return (
        <>
            <h1>{name}</h1>
            <h2>{name}</h2>
            <h3>{name}</h3>
            <Person name={name} />
            <input
                type="text"
                value={name}
                onChange={(e) => setName(e.target.value)}
            />
        </>
    );
};

export default Name;
