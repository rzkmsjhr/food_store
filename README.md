## Food store

The food-store is a web application for cat owners.
The business owners noticed that they're losing customers over time because:
1. The app is slow and buggy
2. The app does not support coupons for discounts
3. It doesn't look good on small screens

And they hired you to make it better by doing the following:

1. Fix a bug-a1: When a customer removes a product the total doesn't update.
2. Fix a bug-a2: Products with different breeds should not be on the same cart. When a customer tries to add
   a product with a different breed, we should display a message explaining this cannot happen, and he must add only
   products with the same breed.
3. Fix a bug-a3: Sometimes cart total is empty.
4. Add pagination and display only 20 products per page.
5. Make the products and cart pages responsive and looks fine on small screens.
6. Add coupon feature (see below for more details).
7. Write automated tests for cart functionalities and coupon feature.

Set up a git repository with this project, then make all the changes above in
separate commits for easy reviewing. When done, upload it to GitHub as a
**private** repository and share it with @rubik and @abachi.

### Coupon feature

#### Customer perspective
On the cart page (/cart) the customer should see:
1. A text input that accepts coupon code
2. "Apply coupon" button

Rules:
1. Customer must be able to apply an existing coupon to get a discount
2. See a message for success and error cases
3. Only one coupon can be applied If a customer tries many coupons they should get the one with the biggest discount.

There are three types of coupons:

**1. Absolute**: Coupons of this type have a fixed discount amount.

Example: if the cart total is $100 and a customer applied coupon with type `absolute` that has $10 discount amount the total will be $90.

**2. Percent**: Coupons of this type have percentage discount.

Example: if the cart total is 90$ and a customer applied a coupon with type `percent` that has 20% then the total should be $72 `$90 - (20% of $90) = $72`

**3. Magical**: Coupons of this type have coupon have a fixed discount which it is calculated as follows:
1. Sum the three parts of the current date (year + month + day)
2. If the sum is odd then use $15 as a discount otherwise use $10

Example: if the total cart is $100 and a customer applied a coupon with type `magical` and the current date is 2022-12-25 then the total should be $85.

Explanation: `2022 + 12 + 25 = 2059` and since 2059 is odd the discount is $15 => `$100 - $15 = $85`

#### Business owner perspective
1. Create an admin panel under the route `/secret/admin` (a basic Bootstrap style is fine, we don't need an elaborate UI).
2. Admin can create, update, and delete coupons.
3. Admin can see available coupons and their status (active/inactive).
4. Admin can change coupon's status (active/inactive).

Rules:
1. Admin must be authenticated to be able to the do any action.
2. Admin can be added only via a seeder (We don't want everybody to create an account and becomes an admin)

## Installation
#### PostgreSQL
1. Download it from https://www.postgresql.org/ and install it (leave the port to its default, 5432)
2. If you want to use a GUI instead of psql in the terminal, pgAdmin is one option: https://www.pgadmin.org/

Check this video for a Windows walkthrough for both: https://www.youtube.com/watch?v=yg3jPmPlRlI

3. Create a new database `food_store` (check the video above if you want to use pgAdmin, otherwise you can run `psql -U <your Windows username>` and then inside the psql session run `CREATE DATABASE food_store;`)
4. Ensure that you can log in with user `postgres` and password `root`, or even better, create a new user (although not necessary for this assignment).
5. Ensure that the `pgsql` and `pdo_pgsql` PHP extensions are enabled in `php.ini`:

```ini
extension=pdo_pgsql
extension=pgsql
```

#### App
1. `git clone https://github.com/PMDLabs/food-store.git`
2. `composer install`
3. `npm install`
4. rename `.env.example` to `.env`
5. in the `.env` file set: `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
6. `php artisan key:generate`
7. `php artisan migrate:fresh --seed`

## Development
* compile CSS/JS: `npm run watch`
* run development server: `php artisan serve`

#### SCSS files
- ``app.scss`` - union of all styles which are compiled into one file `public/css/app.css`
- ``home.scss`` - contains styles specific to the home page

> **Note**: We are using laravel webpack.mix instead of vite (which is now Laravel's default) to compile assets.
