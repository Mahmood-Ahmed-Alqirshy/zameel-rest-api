<?php

it('import CSV data and seed it', function () {
    expect(count(CSV('subjects')))->toBe(100);
});
