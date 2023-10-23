<?php

$js_arr = ["js/stipulation.js"];
$g_title = "약관";
$menu_code = "register";
include "./common_php/inc_header.php";
?>

<!-- 메인 -->
<main class="p-5 border rounded-5">
    <!-- 약관 -->
    <h1 class="text-center mb-3">회원 약간 및 개인정보 취급방침 동의</h1>
    <h4>회원 약관</h4>
    <textarea name="" id="" cols="30" rows="10" class="form-control">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati ex modi dicta soluta, perspiciatis quis sint itaque nobis ullam explicabo corrupti quaerat dolores sapiente nulla, alias, ad labore eius dignissimos rem nihil molestiae quo debitis ratione eaque. Quibusdam blanditiis nisi maxime cum, quasi veritatis soluta debitis minima pariatur itaque atque neque minus cupiditate odio at fugit eius porro! Dolores vitae sapiente inventore ea. Iusto corporis voluptas ducimus. Iure fuga exercitationem voluptates at voluptatibus omnis mollitia quasi dolore officiis facilis provident est, laborum aperiam necessitatibus minima asperiores sapiente veritatis similique facere sunt? Molestias, quidem minus debitis deleniti fuga libero quibusdam nesciunt, assumenda ratione incidunt officiis ipsa ipsum magnam sapiente, cumque quo repudiandae cupiditate similique fugiat excepturi dolore quam ipsam alias? Ea excepturi doloremque enim cum quisquam libero, obcaecati esse assumenda alias cumque reiciendis fugit, reprehenderit, similique id aliquam animi nostrum minima ipsa dolores! Et facere qui assumenda tempore autem, omnis delectus facilis fuga, pariatur quia commodi nam adipisci necessitatibus vero ex eligendi quasi itaque eaque nulla, ullam praesentium obcaecati tenetur. Minima, odio tenetur rerum cumque alias laboriosam veniam consequuntur cupiditate dolorem culpa, incidunt saepe libero sint ab animi commodi labore. Nostrum natus voluptatum eius nulla architecto quo sapiente molestias illo ex quia commodi quas veniam perspiciatis aspernatur, repellendus voluptate voluptas minus dolore unde esse rerum animi amet iusto. Consequatur, ut consectetur eveniet vitae, aliquam quasi sequi totam quis blanditiis impedit minus expedita quod tempora nulla, iusto necessitatibus! Quidem ut labore animi omnis corporis consequatur totam eaque libero deleniti magnam. Saepe consequatur soluta assumenda nisi perspiciatis harum earum qui corrupti, delectus similique facere? Nostrum, pariatur? Incidunt quae voluptas unde aliquam magnam reprehenderit accusantium maiores necessitatibus tempore praesentium sunt blanditiis magni ullam eius, dignissimos similique culpa rem saepe repudiandae nulla illo dolorem doloremque voluptatibus? Omnis vero ullam explicabo quod est sapiente possimus. Nam.
    </textarea>

    <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" value="1" id="chk_member1">
        <label class="form-check-label" for="chk_member1">
            위 약관에 동의하시겠습니까?
        </label>
    </div>

    <!-- 개인정보 취급방침 -->
    <h4 class="mt-3">개인정보 취급방침</h4>
    <textarea name="" id="" cols="30" rows="10" class="form-control">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum id fugit animi dolorem? Quod repellendus eveniet, nemo assumenda cum nulla alias tempora. Distinctio veniam commodi minima cupiditate alias, animi autem, aperiam recusandae eius velit et reiciendis deleniti hic dolor illo, quo ex sapiente in. Possimus aliquam vero harum facere, dicta exercitationem! Dolore distinctio facere perspiciatis consectetur voluptate officia ab nemo, fuga similique et. Quam eveniet voluptatibus nihil, aspernatur qui molestiae illum sint maxime sed? Perspiciatis quibusdam consequuntur modi ea sequi! Doloremque voluptatem, obcaecati quia molestiae voluptatibus dolorum alias, consequuntur aliquam rerum facilis nemo doloribus expedita velit illo? Mollitia sunt officia nisi enim delectus facere? Molestias modi, aspernatur quisquam rerum voluptatibus aliquam exercitationem vitae obcaecati! Consequatur, itaque? Sequi delectus ipsa eaque iure, aspernatur ullam quis inventore officiis quae dignissimos nesciunt magni obcaecati unde, omnis quisquam neque nostrum, vero consequuntur aliquid cupiditate assumenda eveniet sapiente voluptatum. Repellendus, quibusdam illum dolores et ipsam quaerat nihil magni nam culpa nulla amet perferendis atque magnam, voluptates suscipit ipsa animi sit enim adipisci odio laboriosam sapiente accusamus minus accusantium. Asperiores minima quasi mollitia optio facilis nesciunt consequatur maxime, qui amet. Reprehenderit ea eligendi illum dicta rem quis et hic deleniti consequuntur facere, placeat tempora voluptate quo porro sapiente nesciunt fugiat ipsa qui ullam culpa neque? Excepturi cumque temporibus iure odio facere hic consequuntur animi soluta fugiat! Non architecto consectetur nisi deleniti aliquam earum illum quam quibusdam atque eius. Libero architecto obcaecati iure autem, nam facilis quo nihil ad soluta excepturi quibusdam sunt similique, dolore fugiat officia atque qui eaque possimus tempore itaque aspernatur saepe? Natus qui excepturi ab illum, in corrupti iusto voluptatem architecto iure animi quis dicta ad aliquam ex repellendus officiis nulla doloremque, earum quisquam. Iure sapiente ut excepturi esse ullam, quidem nihil fugiat similique explicabo sed nisi nesciunt animi assumenda. Nam, voluptatibus eveniet.
    </textarea>

    <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" value="2" id="chk_member2">
        <label class="form-check-label" for="chk_member2">
            위 개인정보 취급방침에 동의하시겠습니까?
        </label>
    </div>

    <!-- 버튼 -->
    <div class="d-flex justify-content-center mt-4 gap-2">
        <button class="btn btn-primary w-50" id="btn_member">회원가입</button>
        <button class="btn btn-secondary w-50">가입취소</button>
    </div>

    <!-- 회원가입 페이지 바로가기 방지 -->
    <form action="./member_register.php" method="POST" name="stipulation_form" style="display: none;">
        <input type="hidden" name="chk" value="0">
    </form>
</main>

<?php
include "./common_php/inc_footer.php";
?>