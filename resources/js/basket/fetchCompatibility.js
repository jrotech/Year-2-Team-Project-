export const fetchCompatibility = async (basketItems) => {
    try {
      const payload = {
        products: basketItems.map(item => ({ id: item.id, quantity: item.quantity }))
      };
      const req = await fetch('/api/check-compatibility', {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        method: 'POST',
        body: JSON.stringify(payload),
      });
      const res = await req.json();
      return res;
    } catch (e) {
      console.log(e);
    }
  };
  