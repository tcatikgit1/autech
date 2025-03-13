<div id="skeleton-history-payments" class="container py-5">
    <div class="table-responsive rounded">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th><div class="skeleton-title" style="width: 80px; height: 15px;"></div></th>
                    <th><div class="skeleton-title" style="width: 60px; height: 15px;"></div></th>
                    <th><div class="skeleton-title" style="width: 100px; height: 15px;"></div></th>
                    <th><div class="skeleton-title" style="width: 60px; height: 15px;"></div></th>
                    <th><div class="skeleton-title" style="width: 60px; height: 15px;"></div></th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 5; $i++)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                {{-- <div class="skeleton-img" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;"></div> --}}
                                <div>
                                    <div class="skeleton-title" style="width: 100px; height: 10px; margin-bottom: 5px;"></div>
                                    <div class="skeleton-title" style="width: 60px; height: 10px;"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="skeleton-title" style="width: 80px; height: 10px; margin-bottom: 5px;"></div>
                            <div class="skeleton-title" style="width: 50px; height: 10px;"></div>
                        </td>
                        <td><div class="skeleton-title" style="width: 90px; height: 10px;"></div></td>
                        <td><div class="skeleton-title" style="width: 50px; height: 10px;"></div></td>
                        <td>
                            <div class="skeleton-btn" style="width: 70px; height: 20px; border-radius: 10px;"></div>
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>