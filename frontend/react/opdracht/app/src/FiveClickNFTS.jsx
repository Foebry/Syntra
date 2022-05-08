import { useState, useEffect } from "react";
import axios from "axios";
import ImageNFT from "./ImageNFT";

const FiveClickNFTS = () => {
    const [counter, setCounter] = useState(5);
    const [data, setData] = useState([]);
    const [error, setError] = useState(false);
    const [loading, setLoading] = useState(false);
    const url = "https://api.opensea.io/api/v1/assets?format=json&limit=100";

    useEffect(() => {
        if (!counter) {
            (async () => {
                try {
                    setData([]);
                    setLoading(true);
                    setError(false);
                    const {
                        data: { assets },
                    } = await axios(url);
                    setLoading(false);
                    setData(assets);
                    setCounter(5);
                } catch (error) {
                    setLoading(false);
                    setError(true);
                    setData([]);
                }
            })();
        }
    }, [counter]);
    return (
        <>
            <main>
                <button onClick={() => setCounter(counter - 1)}>
                    click me {counter}
                </button>
                <section>
                    {error && <section>ERROR</section>}
                    {loading && <section>LOADING!</section>}
                    {data.length > 0 && (
                        <>
                            {data
                                .filter((asset) => asset.image_thumbnail_url)
                                .slice(0, 20)
                                .map(({ id, image_thumbnail_url: href }) => (
                                    <ImageNFT key={id} href={href} />
                                ))}
                        </>
                    )}
                </section>
            </main>
        </>
    );
};

export default FiveClickNFTS;
