import axios from "axios";

(async () => {
    const products = await axios.get("http://127.0.0.1:1234/products");
    console.log(products.data);
    console.log("\n\n");

    await axios.post("http://127.0.0.1:1234/products", {
            id: "789",
            name:"Samsung phone",
            image: ""
    })

    const newProducts = await axios.get("http://127.0.0.1:1234/products");
    console.log(newProducts.data);
    console.log("\n\n");
    try {
        await axios.delete("http://127.0.0.1:1234/products/dAD9tas")
    }catch(error) {
        console.log("error");
    }
    

    const productsRepaired = await axios.get("http://127.0.0.1:1234/products");
    console.log(productsRepaired.data);
    console.log("\n\n");
})()