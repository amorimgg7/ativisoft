<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Integração Mercado Pago com Pix</title>
  <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>
  <div id="paymentBrick_container"></div>
  <div id="qrCodeContainer"></div>

  <script>
    // Substitua por sua chave de teste do Mercado Pago
    const mp = new MercadoPago('TEST-767dfaf0-1461-48ee-9b84-17cc1c784b45', {
      locale: 'pt'
    });

    const bricksBuilder = mp.bricks();

    async function renderPaymentBrick(bricksBuilder) {
      const settings = {
        initialization: {
          amount: 80, // Valor total a pagar
          preferenceId: 250, // ID da preferência (obtida no seu servidor)
          payer: {
            firstName: "Gabriel", // Nome do pagador (opcional)
            lastName: "Amorim", // Sobrenome do pagador (opcional)
            email: "amorimgg77@gmail.com" // Email do pagador (opcional)
          }
        },
        customization: {
          visual: {
            style: {
              theme: "default"
            }
          },
          paymentMethods: {
            atm: "all",
            wallet_purchase: "all",
            bankTransfer: "all",
            maxInstallments: 1
          }
        },
        callbacks: {
          onReady: () => {
            // Callback quando o brick estiver pronto
            console.log('Brick do Mercado Pago pronto!');
          },
          onSubmit: ({ selectedPaymentMethod, formData }) => {
            // Callback quando o usuário envia os dados de pagamento
            return fetch('/process_payment', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                selectedPaymentMethod,
                formData
              })
            })
            .then(response => response.json())
            .then(response => {
              if (response.status === 'success') {
                console.log('Pagamento realizado com sucesso!');

                // Gere o QR Code com a preferenceId da resposta do servidor
                const preferenceId = response.preferenceId;
                generateQRCode(preferenceId);
              } else {
                console.error('Erro no processamento do pagamento:', response.message);
                // Exiba uma mensagem de erro para o usuário.
              }
            })
            .catch(error => {
              console.error('Erro na comunicação com o servidor:', error);
              // Exiba uma mensagem de erro para o usuário.
            });
          },
          onError: (error) => {
            // Callback para erros do brick
            console.error('Erro no brick do Mercado Pago:', error);
          }
        }
      };

      const paymentBrickController = await bricksBuilder.create("payment", "paymentBrick_container", settings);
    }

    async function generateQRCode(preferenceId) {
      try {
        const qrCodeResponse = await mp.qrCodes.create({
          preferenceId: preferenceId
        });

        const qrCodeURL = qrCodeResponse.qrCode;
        console.log('QR Code gerado:', qrCodeURL);

        const qrCodeContainer = document.getElementById('qrCodeContainer');
        if (qrCodeContainer) {
          qrCodeContainer.innerHTML = `<img src="${qrCodeURL}" alt="QR Code do Mercado Pago">`;
        }
      } catch (error) {
        console.error('Erro ao gerar QR Code:', error);
      }
    }

    renderPaymentBrick(bricksBuilder);
  </script>
</body>
</html>
