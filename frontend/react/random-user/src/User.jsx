import { useState, useEffect } from "react";
import axios from "axios";

const User = () => {
    const [users, setUsers] = useState([]);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(false);
    const [counter, setCounter] = useState(20);
    const [gender, setGender] = useState("");
    const genderTypes = [ "", "male", "female"];

    useEffect(() => {
        (async () => {
            try {
                setLoading(true);
                const {
                    data: { results },
                } = await axios(
                    `https://randomuser.me/api/?results=${counter}&format=json&gender=${gender}`
                );
                setLoading(false);
                setError(false);
                setUsers(results);
            } catch (error) {
                setLoading(false);
                setError(true);
            }
        })();
    }, [counter, gender]);

    return (
        <div>
            <h1>Random Users</h1>
            <button onClick={() => setCounter(counter + 2)}>
                Verhoog met 2
            </button>
            <input
                type="number"
                value={counter}
                onChange={(e) => setCounter(parseInt(e.target.value))}
            />
            <select name="" id="" onChange={(e)=>setGender(e.target.value)}>
                {genderTypes.map((type, i) => <option key={i} selected={type==gender}>{type}</option>)}
            </select>
            {loading && <p>LOADING...</p>}
            {error && <p>ERROR!!</p>}
            {users.length > 0 && (
                <section className="cols">
                    {users.map(
                        ({
                            name: { title, first, last },
                            login: { uuid },
                            picture: { large },
                        }) => (
                            <div key={uuid} className="col">
                                <h1>
                                    {title} {first} {last}
                                </h1>
                                <img src={large} />
                            </div>
                        )
                    )}
                </section>
            )}
        </div>
    );
};

export default User;
