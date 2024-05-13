<footer class="c-footer">
    <div>Copyright &copy; {{ date('Y') }} <strong><a target="_blank"
                href="https://www.facebook.com/JosephM.Tanquilan">{{ auth()->user()->hasRole('Super Admin') ? settings()->company_name: auth()->user()->store->store_name }}</a></strong>
    </div>
    <div class="mfs-auto d-md-down-none">Version <strong class="text-danger">1.0</strong></div>
</footer>
