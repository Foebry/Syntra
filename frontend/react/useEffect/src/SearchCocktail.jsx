import axios from "axios";
import { useState, useEffect } from "react";

const SearchCocktail = () => {
    const [input, setInput] = useState("");
    const [valueToSearch, setValueToSearch] = useState("");
    const [data, setData] = useState([]);
    const [error, setError] = useState(false);
    const [loading, setLoading] = useState(false);
    // useEffect met dependencyarray [valueToSearch] zal functie uitvoeren onMount + wanneer value to search wijzigt
    useEffect(() => {
        (async () => {
            if (valueToSearch) {
                try {
                    setLoading(true);
                    setError(false);
                    const {
                        data: { drinks },
                    } = await axios(
                        `https://www.thecocktaildb.com/api/json/v1/1/filter.php?i=${valueToSearch}`
                    );
                    if (drinks.length > 0) {
                        setError(false);
                        setLoading(false);
                        setData(drinks);
                    }
                } catch (error) {
                    setLoading(false);
                    setError(true);
                    setData([]);
                }
            }
        })();
    }, [valueToSearch]);
    return (
        <>
            <form
                action=""
                onSubmit={(e) => {
                    e.preventDefault();
                    setValueToSearch(input);
                    setInput("");
                }}
            >
                <input
                    type="text"
                    value={input}
                    onChange={(e) => setInput(e.target.value)}
                />
                <button>zoek cocktails</button>
            </form>
            {error && <p>No resulst</p>}
            {loading && <p>Loading..</p>}

            {data.length > 0 && (
                <>
                    <h2>Results based on your search: "{valueToSearch}"</h2>
                    <ul>
                        {data.map(({ strDrink, idDrink }) => (
                            <li key={idDrink}>{strDrink}</li>
                        ))}
                    </ul>
                </>
            )}
        </>
    );
};

export default SearchCocktail;
