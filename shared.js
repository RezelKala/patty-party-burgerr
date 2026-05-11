// ============================================================
// PATTY PARTY BURGER — shared.js
// Cart management, toast notifications, cart badge, menu data
// ============================================================

// ============================================================
// CART HELPERS
// ============================================================

function getCart() {
  try {
    return JSON.parse(localStorage.getItem('ppCart') || '[]');
  } catch (e) {
    return [];
  }
}

function saveCart(cart) {
  localStorage.setItem('ppCart', JSON.stringify(cart));
  updateCartBadge();
}

function addToCart(name, price, img) {
  const cart = getCart();
  const existing = cart.find(i => i.name === name && i.img === img);
  if (existing) {
    existing.qty += 1;
  } else {
    cart.push({ name, price, img, qty: 1 });
  }
  saveCart(cart);
  showToast('🛒 ' + name + ' added to cart!');
  updateCartBadge();
}

// ============================================================
// CART BADGE
// ============================================================

function updateCartBadge() {
  const cart = getCart();
  const total = cart.reduce((sum, i) => sum + (i.qty || 1), 0);
  document.querySelectorAll('.cart-badge').forEach(el => {
    el.textContent = total;
  });
}

// ============================================================
// TOAST
// ============================================================

function showToast(msg, duration) {
  duration = duration || 2500;
  // Remove existing toasts
  document.querySelectorAll('.toast').forEach(t => t.remove());

  const toast = document.createElement('div');
  toast.className = 'toast';
  toast.textContent = msg;
  document.body.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transition = 'opacity 0.4s';
    setTimeout(() => toast.remove(), 400);
  }, duration);
}

// ============================================================
// MENU DATA
// ============================================================

const menuData = {
  burger: [
    {
      name: 'Classic Cheese Burger',
      price: 45000,
      desc: 'Juicy beef patty with melted cheddar cheese',
      img: 'https://images.unsplash.com/photo-1553979459-d2229ba7433b?w=300&q=80'
    },
    {
      name: 'Double Patty Deluxe',
      price: 65000,
      desc: 'Double the beef, double the flavour!',
      img: 'https://images.unsplash.com/photo-1565299507177-b0ac66763828?w=300&q=80'
    },
    {
      name: 'Spicy Chicken Burger',
      price: 48000,
      desc: 'Crispy chicken with spicy mayo & jalapeño',
      img: 'https://images.unsplash.com/photo-1625228024892-55ec66d7e0aa?w=300&q=80'
    },
    {
      name: 'Fish Fillet Burger',
      price: 47000,
      desc: 'Crispy fish fillet with classic tartar sauce',
      img: 'https://images.unsplash.com/photo-1571091718767-18b5b1457add?w=300&q=80'
    },
    {
      name: 'BBQ Smokehouse Burger',
      price: 58000,
      desc: 'Smoky beef patty, bacon, onion rings & BBQ',
      img: 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=300&q=80'
    },
    {
      name: 'Mushroom Swiss Burger',
      price: 52000,
      desc: 'Sautéed mushrooms, Swiss cheese & garlic mayo',
      img: 'https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?w=300&q=80'
    },
    {
      name: 'Veggie Burger',
      price: 40000,
      desc: 'Plant-based patty with fresh veggies & hummus',
      img: 'https://images.unsplash.com/photo-1520072959219-c595dc870360?w=300&q=80'
    },
    {
      name: 'Avocado Bliss Burger',
      price: 55000,
      desc: 'Beef patty with fresh avocado, bacon & ranch',
      img: 'https://images.unsplash.com/photo-1550547660-d9450f859349?w=300&q=80'
    }
  ],
  sides: [
    {
      name: 'Crispy French Fries',
      price: 22000,
      desc: 'Golden, crunchy fries with your choice of sauce',
      img: 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=300&q=80'
    },
    {
      name: 'Onion Rings',
      price: 25000,
      desc: 'Beer-battered onion rings, served crispy hot',
      img: 'https://images.unsplash.com/photo-1639024471283-03518883512d?w=300&q=80'
    },
    {
      name: 'Coleslaw',
      price: 18000,
      desc: 'Creamy homemade coleslaw with a tangy kick',
      img: 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=300&q=80'
    },
    {
      name: 'Cheese Fries',
      price: 28000,
      desc: 'Fries smothered in warm melted cheddar sauce',
      img: 'https://images.unsplash.com/photo-1630384060421-cb20d0e0649d?w=300&q=80'
    },
    {
      name: 'Chicken Nuggets (6pc)',
      price: 32000,
      desc: 'Crispy golden nuggets, perfect for sharing',
      img: 'https://images.unsplash.com/photo-1562802378-063ec186a863?w=300&q=80'
    },
    {
      name: 'Loaded Nachos',
      price: 35000,
      desc: 'Tortilla chips, cheese, jalapeño & sour cream',
      img: 'https://images.unsplash.com/photo-1513456852971-30c0b8199d4d?w=300&q=80'
    }
  ],
  drinks: [
    {
      name: 'Cola Float',
      price: 22000,
      desc: 'Ice cold cola topped with a scoop of vanilla ice cream',
      img: 'https://images.unsplash.com/photo-1625772299848-391b6a87d7b3?w=300&q=80'
    },
    {
      name: 'Fresh Lemonade',
      price: 20000,
      desc: 'Freshly squeezed lemonade with mint & ice',
      img: 'https://images.unsplash.com/photo-1576866209830-589e1bfbaa4d?w=300&q=80'
    },
    {
      name: 'Chocolate Milkshake',
      price: 28000,
      desc: 'Thick, creamy chocolate shake topped with whipped cream',
      img: 'https://images.unsplash.com/photo-1568901839119-631418a3910d?w=300&q=80'
    },
    {
      name: 'Strawberry Milkshake',
      price: 28000,
      desc: 'Sweet strawberry shake blended to perfection',
      img: 'https://images.unsplash.com/photo-1553530666-ba11a90a3af2?w=300&q=80'
    },
    {
      name: 'Iced Tea',
      price: 15000,
      desc: 'Refreshing iced tea, lightly sweetened',
      img: 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=300&q=80'
    },
    {
      name: 'Mineral Water',
      price: 8000,
      desc: 'Plain still mineral water, 600ml',
      img: 'https://images.unsplash.com/photo-1548839140-29a749e1cf4d?w=300&q=80'
    }
  ],
  dessert: [
    {
      name: 'Chocolate Lava Cake',
      price: 32000,
      desc: 'Warm chocolate cake with a gooey molten centre',
      img: 'https://images.unsplash.com/photo-1624353365286-3f8d62daad51?w=300&q=80'
    },
    {
      name: 'Vanilla Ice Cream',
      price: 18000,
      desc: 'Two scoops of rich, creamy vanilla ice cream',
      img: 'https://images.unsplash.com/photo-1570197571499-166b36435e9f?w=300&q=80'
    },
    {
      name: 'Cheesecake Slice',
      price: 35000,
      desc: 'Creamy New York-style cheesecake with berry topping',
      img: 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?w=300&q=80'
    },
    {
      name: 'Churros & Dip',
      price: 28000,
      desc: 'Cinnamon-dusted churros with chocolate dipping sauce',
      img: 'https://images.unsplash.com/photo-1624988804563-9949e4f43e72?w=300&q=80'
    }
  ]
};

// ============================================================
// INIT — run on every page load
// ============================================================

document.addEventListener('DOMContentLoaded', function () {
  updateCartBadge();

  // Show user name in nav if logged in
  const userData = JSON.parse(localStorage.getItem('ppUserData') || '{}');
  if (userData && userData.name) {
    const signinLink = document.querySelector('a[href="signin.html"].btn-signin');
    if (signinLink) {
      signinLink.textContent = '👤 ' + userData.name.split(' ')[0];
      signinLink.href = '#';
      signinLink.onclick = function (e) {
        e.preventDefault();
        if (confirm('Log out dari akun ' + userData.name + '?')) {
          localStorage.removeItem('ppUser');
          localStorage.removeItem('ppUserData');
          location.reload();
        }
      };
    }
  }
});