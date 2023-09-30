import React from "react";
import { BrowserRouter as Router, Switch, Route, Link } from "react-router-dom";
import CryptoJS from "crypto-js";

// Homepage component explaining cryptography
const Home = () => (
  <div>
    <h1>Welcome to the Cryptography App</h1>
    <p>
      Cryptography is the practice of securing communication from adversaries.
      It involves techniques such as encryption and decryption to protect
      sensitive data.
    </p>
    <p>
        Encryption is the process of converting plaintext into ciphertext. The
        ciphertext can be decrypted back to plaintext using a secret key. The
        most common encryption algorithms are AES and RSA.

        AES (Advanced Encryption Standard) is a symmetric encryption algorithm
        that uses the same key for both encryption and decryption. It is a
        block cipher that encrypts data in blocks of 128 bits. AES supports
        key sizes of 128, 192 and 256 bits.

        RSA is an asymmetric encryption algorithm that uses different keys for
        encryption and decryption. It is based on the fact that finding the
        factors of an integer is hard (the factoring problem). RSA supports
        key sizes of 1024, 2048 and 3072 bits.

        Cryptography is used in many applications such as banking transactions,
        password storage, and VPNs.

        This app demonstrates how to use the CryptoJS library to encrypt and
        decrypt text and files.

        The source code for this app can be found at github.com/d-a-s-h-o/crypto/crypto.dasho.dev/app.

        For more information on cryptography, visit the following links:

        <a href="https://en.wikipedia.org/wiki/Cryptography">Cryptography</a>
        <a href="https://en.wikipedia.org/wiki/Advanced_Encryption_Standard">AES</a>
        <a href="https://en.wikipedia.org/wiki/RSA_(cryptosystem)">RSA</a>
        <a href="https://cryptojs.gitbook.io/docs/">CryptoJS</a>

        This app was created by Dasho.

        <a href="https://dasho.dev">dasho.dev</a>
    </p>
  </div>
);

// Encryption component for text and file encryption
const Encrypt = () => {
  const [text, setText] = React.useState("");
  const [encryptedText, setEncryptedText] = React.useState("");
  const [file, setFile] = React.useState(null);
  const [encryptedFile, setEncryptedFile] = React.useState(null);

  const handleTextChange = (e) => {
    setText(e.target.value);
  };

  const handleFileChange = (e) => {
    setFile(e.target.files[0]);
  };

  const encryptText = () => {
    const encrypted = CryptoJS.AES.encrypt(text, "secretkey").toString();
    setEncryptedText(encrypted);
  };

  const encryptFile = () => {
    const reader = new FileReader();
    reader.onload = () => {
      const encrypted = CryptoJS.AES.encrypt(reader.result, "secretkey").toString();
      setEncryptedFile(encrypted);
    };
    reader.readAsDataURL(file);
  };

  return (
    <div>
      <h1>Encryption</h1>
      <div>
        <label>Enter text to encrypt:</label>
        <input type="text" value={text} onChange={handleTextChange} />
        <button onClick={encryptText}>Encrypt Text</button>
        <p>Encrypted Text: {encryptedText}</p>
      </div>
      <div>
        <label>Choose file to encrypt:</label>
        <input type="file" onChange={handleFileChange} />
        <button onClick={encryptFile}>Encrypt File</button>
        {encryptedFile && (
          <p>
            Encrypted File:
            <a href={encryptedFile} download>
              Download
            </a>
          </p>
        )}
      </div>
    </div>
  );
};

// Decryption component for text and file decryption
const Decrypt = () => {
  const [encryptedText, setEncryptedText] = React.useState("");
  const [decryptedText, setDecryptedText] = React.useState("");
  const [encryptedFile, setEncryptedFile] = React.useState(null);
  const [decryptedFile, setDecryptedFile] = React.useState(null);

  const handleTextChange = (e) => {
    setEncryptedText(e.target.value);
  };

  const handleFileChange = (e) => {
    setEncryptedFile(e.target.files[0]);
  };

  const decryptText = () => {
    const decrypted = CryptoJS.AES.decrypt(encryptedText, "secretkey").toString(CryptoJS.enc.Utf8);
    setDecryptedText(decrypted);
  };

  const decryptFile = () => {
    const reader = new FileReader();
    reader.onload = () => {
      const decrypted = CryptoJS.AES.decrypt(reader.result, "secretkey").toString(CryptoJS.enc.Utf8);
      setDecryptedFile(decrypted);
    };
    reader.readAsDataURL(encryptedFile);
  };

  return (
    <div>
      <h1>Decryption</h1>
      <div>
        <label>Enter text to decrypt:</label>
        <input type="text" value={encryptedText} onChange={handleTextChange} />
        <button onClick={decryptText}>Decrypt Text</button>
        <p>Decrypted Text: {decryptedText}</p>
      </div>
      <div>
        <label>Choose file to decrypt:</label>
        <input type="file" onChange={handleFileChange} />
        <button onClick={decryptFile}>Decrypt File</button>
        {decryptedFile && (
          <p>
            Decrypted File:
            <a href={decryptedFile} download>
              Download
            </a>
          </p>
        )}
      </div>
    </div>
  );
};

// App component with routes
const App = () => (
  <Router>
    <nav>
      <ul>
        <li>
          <Link to="/">Home</Link>
        </li>
        <li>
          <Link to="/encrypt">Encrypt</Link>
        </li>
        <li>
          <Link to="/decrypt">Decrypt</Link>
        </li>
      </ul>
    </nav>

    <Switch>
      <Route exact path="/" component={Home} />
      <Route path="/encrypt" component={Encrypt} />
      <Route path="/decrypt" component={Decrypt} />
    </Switch>
  </Router>
);

// Render the App component
ReactDOM.render(<App />, document.getElementById("root"));