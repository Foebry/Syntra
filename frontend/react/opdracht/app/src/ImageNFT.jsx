const ImageNFT = ({ id, href }) => {
    return (
        <>
            <aside key={id}>
                <div className="imgholder">
                    <img src={href} />
                </div>
            </aside>
        </>
    );
};

export default ImageNFT;
